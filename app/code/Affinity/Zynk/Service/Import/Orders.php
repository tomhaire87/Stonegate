<?php

namespace Affinity\Zynk\Service\Import;

use Magento\Framework\App\Filesystem\DirectoryList;

class Orders
{

	/**
	 * @var \Psr\Log\LoggerInterface
	 */
	protected $_logger;

	/**
	 * @var \Magento\Framework\Filesystem\Io\Ftp
	 */
	protected $_ftp;

	/**
	 * @var \Magento\Framework\Filesystem
	 */
	protected $_filesystem;

	/**
	 * @var \Magento\Framework\Xml\Parser
	 */
	protected $_xmlParser;

	/**
	 * @var \Magento\Customer\Model\Group
	 */
	protected $_customerGroup;

	/**
	 * @var OrderFactory
	 */
	protected $_orderFactory;

	/**
	 * @var OrderItemFactory
	 */
	protected $_orderItemFactory;

	/**
	 * @var OrderAddressFactory
	 */
	protected $_orderAddressFactory;

	/**
	 * @var OrderShippingFactory
	 */
	protected $_orderShippingFactory;

	/**
	 * FTP Credentials array
	 *
	 * @var array
	 */
	protected $_credentials	= [];


	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Psr\Log\LoggerInterface $logger,
		\Magento\Framework\Filesystem $filesystem,
		\Magento\Framework\Filesystem\Io\Ftp $ftp,
		\Magento\Framework\App\DeploymentConfig $deploymentConfig,
		\Magento\Framework\Xml\Parser $xmlParser,
		\Magento\Customer\Model\Group $customerGroup,
		\Affinity\OfflineOrders\Model\OrderFactory $orderFactory,
		\Affinity\OfflineOrders\Model\OrderItemFactory $orderItemFactory,
		\Affinity\OfflineOrders\Model\OrderAddressFactory $orderAddressFactory,
		\Affinity\OfflineOrders\Model\OrderShippingFactory $orderShippingFactory
	)
	{
		$this->_logger					= $logger;
		$this->_filesystem				= $filesystem;
		$this->_ftp						= $ftp;
		$this->_xmlParser				= $xmlParser;
		$this->_credentials				= $deploymentConfig->get('ftp/connection/default');
		$this->_customerGroup			= $customerGroup;
		$this->_orderFactory			= $orderFactory;
		$this->_orderItemFactory		= $orderItemFactory;
		$this->_orderAddressFactory		= $orderAddressFactory;
		$this->_orderShippingFactory	= $orderShippingFactory;
	}

	/**
	 * Run Import
	 */
	public function run()
	{
		if ($this->_openFtp()) {
			foreach ($this->_ftp->ls() as $value) {
				$filename	= basename($value['text']);
				$fileparts	= explode('.', $filename);
				if(strtolower(end($fileparts)) == 'xml') {
					$xml	= $this->_ftp->read($value['text']);
					$parsed	= $this->_xmlParser->loadXML($xml);
					$delete	= $this->_processOfflineOrderFromXmlArray($parsed->xmlToArray());
					if($delete) {
						$this->_ftp->rm($value['text']);
					}
				}
			}
			$this->_closeFtp();
		}
	}

	/**
	 * Process an offline order from XML Array
	 *
	 * @param array $orderData
	 *
	 * @return bool
	 */
	protected function _processOfflineOrderFromXmlArray(array $orderData)
	{
		$orders		= $orderData['Company']['SalesOrders'];
		$delete		= true;
		foreach ($orders as $order) {
			$group	= $this->_getCustomerGroupModel($order['AccountReference']);
			if(is_null($group)) {
				$delete = false;
				$this->_logger->error('The group does not exist', ['group' => $order['AccountReference']]);
				continue;
			}
			try {
				$_order	= $this->_orderFactory->create();
				$_order->setGroupId($group->getId());
				$this->_setObjectData($_order, $order, true);
				$_order->save();
			} catch (\Exception $e) {
				$this->_logger->error(
					$e->getMessage(),
					['trace' => $e->getTraceAsString()]
				);
				return false;
			}
			// Create additional entries once we have an Offline Order ID
			foreach ($order as $key => $value) {
				if(is_array($value)) {
					$method	= "_create{$key}";
					if(method_exists($this, $method)) {
						$this->$method($_order, $value);
					}
				}
			}
		}
		return $delete;
	}

	/**
	 * Create Sales Order Address
	 * Created from XML property <SalesOrderAddess>
	 *
	 * @param \Affinity\OfflineOrders\Model\Order $order
	 * @param array $data
	 *
	 * @return \Affinity\Zynk\Service\Import\Orders
	 */
	protected function _createSalesOrderAddress(\Affinity\OfflineOrders\Model\Order $order, array $data)
	{
		return $this->_createOfflineOrderAddress($order, $data);
	}

	/**
	 * Create Sales Order Delivery Address
	 * Created from XML property <SalesOrderDeliveryAddess>
	 *
	 * @param \Affinity\OfflineOrders\Model\Order $order
	 * @param array $data
	 *
	 * @return \Affinity\Zynk\Service\Import\Orders
	 */
	protected function _createSalesOrderDeliveryAddress(\Affinity\OfflineOrders\Model\Order $order, array $data)
	{
		return $this->_createOfflineOrderAddress($order, $data, 'shipping');
	}

	/**
	 * Create Sales Order Address
	 *
	 * @param \Affinity\OfflineOrders\Model\Order $order
	 * @param array  $data
	 * @param string $type
	 *
	 * @return \Affinity\Zynk\Service\Import\Orders
	 */
	protected function _createOfflineOrderAddress(\Affinity\OfflineOrders\Model\Order $order, $data, $type = 'invoice')
	{
		$_address	= $this->_orderAddressFactory->create();
		$_address->setOrderId($order->getId());
		$_address->setAddressType($type);
		$this->_setObjectData($_address, $data);
		$_address->save();
		return $this;
	}

	/**
	 * Create Sales Order Item
	 * Created from XML property <SalesOrderItems>
	 *
	 * @param \Affinity\OfflineOrders\Model\Order $order
	 * @param array $data
	 *
	 * @return \Affinity\Zynk\Service\Import\Orders
	 */
	protected function _createSalesOrderItems(\Affinity\OfflineOrders\Model\Order $order, array $items)
	{
		foreach($items as $item) {
			$_item	= $this->_orderItemFactory->create();
			$_item->setOrderId($order->getId());
			$this->_setObjectData($_item, $item);
			$_item->save();
		}
		return $this;
	}

	/**
	 * Create Sales Order Carriage
	 * Created from XML property <Carriage>
	 *
	 * @param \Affinity\OfflineOrders\Model\Order $order
	 * @param array $data
	 *
	 * @return \Affinity\Zynk\Service\Import\Orders
	 */
	protected function _createCarriage(\Affinity\OfflineOrders\Model\Order $order, array $data)
	{
		$_carriage	= $this->_orderShippingFactory->create();
		$_carriage->setOrderId($order->getId());
		$this->_setObjectData($_carriage, $data);
		$_carriage->save();
		return $this;
	}

	/**
	 * Set object data based on XML Array data
	 * The method is a like-for-like relationship with
	 * the XML data. E.g. XML property `<CurrencyUsed>false</CurrencyUsed>`
	 * equates to `setCurrencyUsed(false)`.
	 *
	 * For new columns added, the column name should be a lowercase
	 * and underscored equivalent. E.g. `CurrencyUsed` => `currency_used`.
	 *
	 * @param \Magento\Framework\Model\AbstractModel $object
	 * @param array $data
	 * @param bool  $download  Whether this specific call of `_setObjectData` should download any PDF files associated
	 *
	 * @return \Affinity\Zynk\Service\Import\Orders
	 */
	protected function _setObjectData(\Magento\Framework\Model\AbstractModel $object, array $data, $download = false)
	{
		foreach ($data as $key => $value) {
			if ($key == 'Id') continue; // We don't want to `SetId()` on the `$_order` Model
			if ($key == 'PDF') $key = 'PdfFile';
			if (($key == 'InvoicePDF' || $key == 'CreditNotePDF') && $download) {
				$this->{"_download{$key}"}($value);
				$key = 'PdfFile';
			}
			if (is_scalar($value)) {
				$method	= "set{$key}";
				$object->$method($value);
			}
		}
		return $this;
	}

	/**
	 * Download Invoice PDF
	 *
	 * @param string $pdfFile
	 */
	protected function _downloadInvoicePDF(string $pdfFile)
	{
		$this->_download('orders/invoices/', $pdfFile);
	}

	/**
	 * Download Credit Note PDF
	 *
	 * @param string $pdfFile
	 */
	protected function _downloadCreditNotePDF(string $pdfFile)
	{
		$this->_download('orders/credit notes/', $pdfFile);
	}

	/**
	 * Download Credit Note or Invoice from FTP
	 *
	 * @param string $directory
	 * @param string $filename
	 */
	protected function _download(string $directory, string $filename)
	{
		$write	= $this->_filesystem->getDirectoryWrite(DirectoryList::ROOT);
		if (!$write->isExist($directory)) {
			$write->create($directory);
		}
		$this->_ftp->read($filename, $write->getAbsolutePath($directory) . basename($filename));
	}


	/**
	 * Create a new sales order instance for
	 * an account, by account reference
	 *
	 * @param string $reference
	 * @return \Magento\Customer\Model\Group|null
	 */
	protected function _getCustomerGroupModel(string $reference)
	{
		$customerGroup	= $this->_customerGroup->load($reference, 'customer_group_code');
		if($customerGroup->getCode() != $reference) {
			return null;
		}
		return $customerGroup;
	}

	/**
	 * Open FTP connection
	 *
	 * @return bool
	 */
	protected function _openFtp()
	{
		return $this->_ftp->open([
			'host'		=> $this->_credentials['host'],
			'user'		=> $this->_credentials['user'],
			'password'	=> $this->_credentials['pass'],
			'passive'	=> true
		]);
	}

	/**
	 * Close FTP connection
	 *
	 * @return bool
	 */
	protected function _closeFtp()
	{
		return $this->_ftp->close();
	}
}