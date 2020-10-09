<?php

namespace Affinity\Zynk\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractConsole extends SymfonyCommand
{

	/**
	 * @var InputInterface
	 */
	protected $_input;

	/**
	 * @var OutputInterface
	 */
	protected $_output;

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->_input	= $input;
		$this->_output	= $output;

		return $this;
	}

	/**
	 * Log errors/notices
	 *
	 * @param null|Exception $message
	 */
	public function log($message)
	{
		$date	= new \DateTime();
		$type	= 'NOTICE';

		if ($message instanceof \Exception) {
			$type		= 'EXCEPTION';
			$message	= $message->getMessage() . PHP_EOL . $message->getTraceAsString();
		}

		$this->_output->writeln("{$date->format('Y-m-d H:i:s')} - {$type} - {$message}");
	}
}