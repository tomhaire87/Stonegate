<?php

namespace Affinity\Zynk\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class Import extends SymfonyCommand
{

	/**
	 * @var \Affinity\Zynk\Console\Import\Orders
	 */
	protected $_orderConsole;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Affinity\Zynk\Console\Import\Orders $orderConsole
	)
	{
		$this->_orderConsole	= $orderConsole;
		parent::__construct('affinity:zynk:import');
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->_orderConsole->run($input, $output);

		return $this;
	}
}