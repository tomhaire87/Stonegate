<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console;

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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return $this
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_input = $input;
        $this->_output = $output;

        return $this;
    }

    public function log($message)
    {
        $date = new \DateTime();
        $type = 'NOTICE';

        if ($message instanceof \Exception) {
            $type = 'EXCEPTION';
            $message = $message->getMessage() . "\n" . $message->getTraceAsString();
        }

        $this->_output->writeln("{$date->format('Y-m-d H:i:s')} - {$type} - {$message}");
    }

}