<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AudereCommerce\AccountsIntegration\Console\Export\Orders as OrdersConsole;

class Export extends SymfonyCommand
{

    /**
     * @var OrdersConsole
     */
    protected $_ordersConsole;

    public function __construct(
        OrdersConsole $ordersConsole
    )
    {
        $this->_ordersConsole = $ordersConsole;

        parent::__construct('auderecommerce:accountsintegration:export');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return $this
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_ordersConsole->run($input, $output);

        return $this;
    }

}