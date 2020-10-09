<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AudereCommerce\AccountsIntegration\Console\Import as ImportConsole;
use AudereCommerce\AccountsIntegration\Console\Export as ExportConsole;

class All extends SymfonyCommand
{

    /**
     * @var Import
     */
    protected $_importConsole;

    /**
     * @var Export
     */
    protected $_exportConsole;

    public function __construct(
        ImportConsole $importConsole,
        ExportConsole $exportConsole
    )
    {
        $this->_importConsole = $importConsole;
        $this->_exportConsole = $exportConsole;

        parent::__construct('auderecommerce:accountsintegration:all');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return $this
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_importConsole->run($input, $output);
        $this->_exportConsole->run($input, $output);

        return $this;
    }

}