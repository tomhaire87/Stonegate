<?php

namespace Affinity\Zynk\Console\Import;

use Affinity\Zynk\Console\AbstractConsole;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class Orders extends AbstractConsole
{

	/**
	 * @var \Affinity\Zynk\Service\Import\Orders
	 */
	protected $orderImport;

	/**
	 * @var \Magento\Framework\App\State
	 **/
	protected $state;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Affinity\Zynk\Service\Import\Orders $orderImport,
		\Magento\Framework\App\State $state
	)
	{
		$this->orderImport	= $orderImport;
		$this->state		= $state;
		parent::__construct('affinity:zynk:import:orders');
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
		$this->orderImport->run();
		parent::execute($input, $output);
	}
}