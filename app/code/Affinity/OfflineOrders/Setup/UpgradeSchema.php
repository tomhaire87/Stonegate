<?php

namespace Affinity\Zynk\Setup;

use Magento\Backend\Test\Block\Widget\Tab;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	/**
	 * {@inheritDoc}
	 *
	 */
	public function upgrade(
		SchemaSetupInterface $setup,
		ModuleContextInterface $context
	)
	{
		$setup->startSetup();
		if(version_compare($context->getVersion(), '0.0.1', '<')) {
			$this->_createOfflineOrderTables($setup);
		}
		$setup->endSetup();
	}

	/**
	 * Create `affinity_offline_order` table
	 * Create `affinity_offline_order_item` table
	 * Create `affinity_offline_order_address` table
	 * Create `affinity_offline_order_shipping` table
	 *
	 * @param SchemaSetupInterface $setup
	 * @return $this
	 * @throws \Zend_Db_Exception
	 */
	protected function _createOfflineOrderTables(SchemaSetupInterface $setup)
	{
		$this->_createOfflineOrderTable($setup);
		$this->_createOfflineOrderItemTable($setup);
		$this->_createOfflineOrderAddressTable($setup);
		$this->_createOfflineOrderShippingTable($setup);

		return $this;
	}

	/**
	 * Create `affinity_offline_order` table
	 *
	 * @param SchemaSetupInterface $setup
	 * @return $this
	 * @throws \Zend_Db_Exception
	 */
	protected function _createOfflineOrderTable(SchemaSetupInterface $setup)
	{
		$table	= $setup->getConnection()
			->newTable(
				$setup->getTable('offline_order')
			)
			->setComment('Offline Order')
			->addColumn(
				'entity_id',
				Table::TYPE_INTEGER,
				null,
				[
					'unsigned'	=> true,
					'nullable'	=> false,
					'identity'	=> true,
					'primary'	=> true
				],
				'Offline Order ID'
			)
			->addColumn(
				'pdf_file',
				Table::TYPE_TEXT,
				255,
				[],
				'PDF Invoice Location'
			)
			->addColumn(
				'unique_id',
				Table::TYPE_INTEGER,
				null,
				[],
				'Unique ID'
			)
			->addColumn(
				'sales_order_number',
				Table::TYPE_INTEGER,
				null,
				[],
				'Sales Order Number'
			)
			->addColumn(
				'customer_order_number',
				Table::TYPE_INTEGER,
				null,
				[],
				'Customer Order Number'
			)
			->addColumn(
				'foreign_rate',
				Table::TYPE_INTEGER,
				null,
				[],
				'Foreign Rate'
			)
			->addColumn(
				'currency',
				Table::TYPE_TEXT,
				32,
				[],
				'Currency'
			)
			->addColumn(
				'account_reference',
				Table::TYPE_TEXT,
				255,
				[],
				'Account Reference'
			)
			->addColumn(
				'group_id',
				Table::TYPE_INTEGER,
				null,
				[
					'unsigned'	=> true,
					'nullable'	=> false
				],
				'Group ID'
			)
			->addColumn(
				'currency_used',
				Table::TYPE_BOOLEAN,
				255,
				[],
				'Currency Used'
			)
			->addColumn(
				'vat_inclusive',
				Table::TYPE_BOOLEAN,
				255,
				[],
				'VAT Inclusive'
			)
			->addColumn(
				'sales_order_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Sales Order Date'
			)
			->addColumn(
				'despatch_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Despatch Date'
			)
			->addColumn(
				'despatch_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Despatch Date'
			)
			->addColumn(
				'promised_delivery_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Promised Delivery Date'
			)
			->addColumn(
				'requested_delivery_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Requested Delivery Date'
			)
			->addColumn(
				'sales_order_type',
				Table::TYPE_TEXT,
				255,
				[],
				'Sales Order Type'
			)
			->addColumn(
				'taken_by',
				Table::TYPE_TEXT,
				255,
				[],
				'Taken By'
			)
			->addColumn(
				'courier',
				Table::TYPE_TEXT,
				255,
				[],
				'Courier'
			)
			->addColumn(
				'settlement_days',
				Table::TYPE_INTEGER,
				null,
				[],
				'Settlement Days'
			)
			->addColumn(
				'settlement_discount',
				Table::TYPE_INTEGER,
				null,
				[],
				'Settlement Discount'
			)
			->addColumn(
				'global_tax_code',
				Table::TYPE_INTEGER,
				null,
				[],
				'Global Tax Code'
			)
			->addColumn(
				'payment_amount',
				Table::TYPE_INTEGER,
				null,
				[],
				'Payment Amount'
			)
			->addColumn(
				'tax_number',
				Table::TYPE_TEXT,
				255,
				[],
				'Tax Number'
			)
			->addColumn(
				'payment_type',
				Table::TYPE_TEXT,
				255,
				[],
				'Payment Type'
			)
			->addColumn(
				'status',
				Table::TYPE_TEXT,
				255,
				[],
				'Status'
			)
			->addColumn(
				'net_value_discount',
				Table::TYPE_INTEGER,
				null,
				[],
				'Net Value Discount'
			)
			->addColumn(
				'net_value_discount_percent',
				Table::TYPE_INTEGER,
				null,
				[],
				'Net Value Discount Percent'
			)
			->addColumn(
				'discount_type',
				Table::TYPE_TEXT,
				255,
				[],
				'Discount Type'
			)
			->addColumn(
				'priority',
				Table::TYPE_TEXT,
				255,
				[],
				'Priority'
			)
			->addColumn(
				'analysis_codes',
				Table::TYPE_TEXT,
				255,
				[],
				'Analysis Codes'
			)
			->addForeignKey(
				$setup->getFkName(
					'offline_order',
					'group_id',
					'customer_group',
					'customer_group_id'
				),
				'group_id',
				$setup->getTable('customer_group'),
				'customer_group_id',
				Table::ACTION_CASCADE
			);
		$setup->getConnection()->createTable($table);
		return $this;
	}

	/**
	 * Create `affinity_offline_order_item` table
	 *
	 * @param SchemaSetupInterface $setup
	 * @return $this
	 * @throws \Zend_Db_Exception
	 */
	protected function _createOfflineOrderItemTable(SchemaSetupInterface $setup)
	{
		$table	= $setup->getConnection()
			->newTable(
				$setup->getTable('offline_order_item')
			)
			->setComment('Offline Order Item')
			->addColumn(
				'entity_id',
				Table::TYPE_INTEGER,
				null,
				[
					'unsigned'	=> true,
					'nullable'	=> false,
					'identity'	=> true,
					'primary'	=> true
				],
				'Offline Order Item ID'
			)
			->addColumn(
				'order_id',
				Table::TYPE_INTEGER,
				null,
				[
					'unsigned'	=> true,
					'nullable'	=> false
				],
				'Offline Order ID'
			)
			->addColumn(
				'sku',
				Table::TYPE_TEXT,
				255,
				[],
				'SKU'
			)
			->addColumn(
				'name',
				Table::TYPE_TEXT,
				255,
				[],
				'Name'
			)
			->addColumn(
				'description',
				Table::TYPE_TEXT,
				null,
				[],
				'Description'
			)
			->addColumn(
				'qty_ordered',
				Table::TYPE_INTEGER,
				null,
				[],
				'QTY Ordered'
			)
			->addColumn(
				'unit_price',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Unit Price'
			)
			->addColumn(
				'unit_discount_amount',
				Table::TYPE_INTEGER,
				null,
				[],
				'Unit Discount Amount'
			)
			->addColumn(
				'unit_discount_percentage',
				Table::TYPE_INTEGER,
				null,
				[],
				'Unit Discount Percentage'
			)
			->addColumn(
				'tax_rate',
				Table::TYPE_INTEGER,
				null,
				[],
				'Tax Rate'
			)
			->addColumn(
				'analysis_codes',
				Table::TYPE_TEXT,
				255,
				[],
				'Analysis Codes'
			)
			->addColumn(
				'batches',
				Table::TYPE_TEXT,
				255,
				[],
				'Batchces'
			)
			->addColumn(
				'total_net',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Total NET'
			)
			->addColumn(
				'total_tax',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Total TAX'
			)
			->addColumn(
				'tax_code',
				Table::TYPE_INTEGER,
				null,
				[],
				'Tax Code'
			)
			->addColumn(
				'nominal_code',
				Table::TYPE_TEXT,
				255,
				[],
				'Nominal Code'
			)
			->addColumn(
				'cost_centre',
				Table::TYPE_TEXT,
				255,
				[],
				'Cost Centre'
			)
			->addColumn(
				'department',
				Table::TYPE_TEXT,
				255,
				[],
				'Department'
			)
			->addColumn(
				'location',
				Table::TYPE_TEXT,
				255,
				[],
				'Location'
			)
			->addColumn(
				'barcode',
				Table::TYPE_TEXT,
				255,
				[],
				'Barcode'
			)
			->addColumn(
				'type',
				Table::TYPE_TEXT,
				255,
				[],
				'Type'
			)
			->addColumn(
				'qty_allocated',
				Table::TYPE_INTEGER,
				null,
				[],
				'Qty Allocated'
			)
			->addColumn(
				'qty_despatched',
				Table::TYPE_INTEGER,
				null,
				[],
				'Qty Despatched'
			)
			->addColumn(
				'qty_received',
				Table::TYPE_INTEGER,
				null,
				[],
				'Qty Received'
			)
			->addColumn(
				'qty_invoiced',
				Table::TYPE_INTEGER,
				null,
				[],
				'Qty Invoiced'
			)
			->addColumn(
				'fulfilment_method',
				Table::TYPE_TEXT,
				255,
				[],
				'Fulfilment Method'
			)
			->addColumn(
				'promised_delivery_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Promised Delivery DAte'
			)
			->addColumn(
				'requested_delivery_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Requested Delivery DAte'
			)
			->addForeignKey(
				$setup->getFkName(
					'offline_order_item',
					'order_id',
					'offline_order',
					'entity_id'
				),
				'order_id',
				$setup->getTable('offline_order'),
				'entity_id',
				Table::ACTION_CASCADE
			);
		$setup->getConnection()->createTable($table);
		return $this;
	}

	/**
	 * Create `affinity_offline_order_address` table
	 *
	 * @param SchemaSetupInterface $setup
	 * @return $this
	 * @throws \Zend_Db_Exception
	 */
	protected function _createOfflineOrderAddressTable(SchemaSetupInterface $setup)
	{
		$table	= $setup->getConnection()
			->newTable(
				$setup->getTable('offline_order_address')
			)
			->setComment('Offline Order Item')
			->addColumn(
				'entity_id',
				Table::TYPE_INTEGER,
				null,
				[
					'unsigned'	=> true,
					'nullable'	=> false,
					'identity'	=> true,
					'primary'	=> true
				],
				'Offline Order Item ID'
			)
			->addColumn(
				'order_id',
				Table::TYPE_INTEGER,
				null,
				[
					'unsigned'	=> true,
					'nullable'	=> false
				],
				'Offline Order ID'
			)
			->addColumn(
				'company',
				Table::TYPE_TEXT,
				255,
				[],
				'Company'
			)
			->addColumn(
				'description',
				Table::TYPE_TEXT,
				null,
				[],
				'Description'
			)
			->addColumn(
				'address_1',
				Table::TYPE_TEXT,
				255,
				[],
				'Address 1'
			)
			->addColumn(
				'address_2',
				Table::TYPE_TEXT,
				255,
				[],
				'Address 2'
			)
			->addColumn(
				'address_3',
				Table::TYPE_TEXT,
				255,
				[],
				'Address 3'
			)
			->addColumn(
				'town',
				Table::TYPE_TEXT,
				255,
				[],
				'Town'
			)
			->addColumn(
				'postcode',
				Table::TYPE_TEXT,
				64,
				[],
				'Postcode'
			)
			->addColumn(
				'country',
				Table::TYPE_TEXT,
				255,
				[],
				'Country'
			)
			->addColumn(
				'telephone',
				Table::TYPE_TEXT,
				255,
				[],
				'Telephone'
			)
			->addColumn(
				'telephone_country_code',
				Table::TYPE_TEXT,
				255,
				[],
				'Telephone Country Code'
			)
			->addColumn(
				'telephone_area_code',
				Table::TYPE_TEXT,
				255,
				[],
				'Telephone Area Code'
			)
			->addColumn(
				'fax',
				Table::TYPE_TEXT,
				255,
				[],
				'Fax'
			)
			->addColumn(
				'fax_country_code',
				Table::TYPE_TEXT,
				255,
				[],
				'Fax Country Code'
			)
			->addColumn(
				'fax_area_code',
				Table::TYPE_TEXT,
				255,
				[],
				'Fax Area Code'
			)
			->addColumn(
				'email',
				Table::TYPE_TEXT,
				255,
				[],
				'Email'
			)
			->addColumn(
				'contact_name',
				Table::TYPE_TEXT,
				255,
				[],
				'Contact Name'
			)
			->addColumn(
				'birthday',
				Table::TYPE_TEXT,
				255,
				[],
				'Birthday'
			)
			->addColumn(
				'notes',
				Table::TYPE_TEXT,
				null,
				[],
				'Notes'
			)
			->addColumn(
				'tax_code',
				Table::TYPE_TEXT,
				255,
				[],
				'Tax Code'
			)
			->addColumn(
				'address_type',
				Table::TYPE_TEXT,
				255,
				[],
				'Address Type'
			)
			->addForeignKey(
				$setup->getFkName(
					'offline_order_address',
					'order_id',
					'offline_order',
					'entity_id'
				),
				'order_id',
				$setup->getTable('offline_order'),
				'entity_id',
				Table::ACTION_CASCADE
			);
		$setup->getConnection()->createTable($table);
		return $this;
	}

	/**
	 * Create `affinity_offline_order_shipping` table
	 *
	 * @param SchemaSetupInterface $setup
	 * @return $this
	 * @throws \Zend_Db_Exception
	 */
	protected function _createOfflineOrderShippingTable(SchemaSetupInterface $setup)
	{
		$table	= $setup->getConnection()
			->newTable(
				$setup->getTable('offline_order_shipping')
			)
			->setComment('Offline Order Item')
			->addColumn(
				'entity_id',
				Table::TYPE_INTEGER,
				null,
				[
					'unsigned'	=> true,
					'nullable'	=> false,
					'identity'	=> true,
					'primary'	=> true
				],
				'Offline Order Item ID'
			)
			->addColumn(
				'order_id',
				Table::TYPE_INTEGER,
				null,
				[
					'unsigned'	=> true,
					'nullable'	=> false
				],
				'Offline Order ID'
			)
			->addColumn(
				'sku',
				Table::TYPE_TEXT,
				255,
				[],
				'SKU'
			)
			->addColumn(
				'qty_ordered',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Qty Ordered'
			)
			->addColumn(
				'unit_price',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Unit Price'
			)
			->addColumn(
				'unit_discount_amount',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Unit Discount Amount'
			)
			->addColumn(
				'unit_discount_percentage',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Unit Discount Percentage'
			)
			->addColumn(
				'tax_rate',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Tax Rate'
			)
			->addColumn(
				'tax_code',
				Table::TYPE_INTEGER,
				null,
				[],
				'Tax Code'
			)
			->addColumn(
				'type',
				Table::TYPE_TEXT,
				255,
				[],
				'Type'
			)
			->addColumn(
				'qty_allocated',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Qty Allocated'
			)
			->addColumn(
				'qty_despatched',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Qty Despatched'
			)
			->addColumn(
				'qty_received',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Qty Received'
			)
			->addColumn(
				'qty_invoiced',
				Table::TYPE_DECIMAL,
				'12,4',
				[],
				'Qty Invoiced'
			)
			->addColumn(
				'fulfilment_method',
				Table::TYPE_TEXT,
				null,
				[],
				'Fulfilment Method'
			)
			->addColumn(
				'promised_delivery_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Promised Delivery Date'
			)
			->addColumn(
				'requested_delivery_date',
				Table::TYPE_DATETIME,
				null,
				[],
				'Requested Delivery Date'
			)
			->addForeignKey(
				$setup->getFkName(
					'offline_order_shipping',
					'order_id',
					'offline_order',
					'entity_id'
				),
				'order_id',
				$setup->getTable('offline_order'),
				'entity_id',
				Table::ACTION_CASCADE
			);
		$setup->getConnection()->createTable($table);
		return $this;
	}

}