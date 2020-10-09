<?php

namespace Affinity\Zynk\Cron\Import;

class Orders
{
	/**
	 * @var \Affinity\Zynk\Service\Import\Order
	 */
	protected $orderImport;

	/**
	 * {inheritdoc}
	 */
	protected $jobCode = 'affinity_zynk_import_orders';


	public function __construct(
		\Affinity\Zynk\Service\Import\Orders $orderImport
	)
	{
		$this->orderImport = $orderImport;
	}

	/**
	 * Run cron
	 */
	public function run()
	{
		$this->orderImport->run();
	}
}