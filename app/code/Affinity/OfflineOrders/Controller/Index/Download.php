<?php

namespace Affinity\OfflineOrders\Controller\Index;

class Download extends AbstractOfflineOrder
{

	/**
	 * @var \Magento\Framework\Filesystem
	 */
	protected $_filesystem;

	/**
	 * @var \Magento\Framework\App\Response\Http\FileFactory
	 */
	protected $_fileFactory;

	/**
	 * @var \Magento\Framework\Filesystem\DirectoryList
	 */
	protected $_directoryList;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\Filesystem $filesystem,
		\Magento\Customer\Model\Session $customerSession,
		\Affinity\OfflineOrders\Model\OrderFactory $orderFactory,
		\Magento\Framework\Filesystem\DirectoryList $directoryList,
		\Magento\Framework\App\Response\Http\FileFactory $fileFactory
	)
	{
		$this->_filesystem		= $filesystem;
		$this->_fileFactory		= $fileFactory;
		$this->_directoryList	= $directoryList;
		parent::__construct($context, $customerSession, $orderFactory);
	}

	/**
	 * @return \Magento\Framework\App\ResponseInterface
	 */
	public function execute()
	{
		$order	= $this->_getOrder();

		if (!$this->_canViewOrder()) return $this->_redirect('offlineorders');

		$root		= \Magento\Framework\App\Filesystem\DirectoryList::ROOT;
		$path		= $this->_directoryList->getPath($root);
		$file		= '/orders/' . $order->getPdfFile();
		$filesystem	= $this->_filesystem->getDirectoryRead($root);

		if(!$filesystem->isExist('/orders/' . $order->getPdfFile())) {
			return $this->_redirect('offlineorders');
		}

		return $this->_fileFactory->create(basename($order->getPdfFile()), [
			'type'	=> 'filename',
			'value'	=> $path . $file
		]);
	}
}