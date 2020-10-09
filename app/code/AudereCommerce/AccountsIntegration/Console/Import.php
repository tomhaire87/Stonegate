<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AudereCommerce\AccountsIntegration\Console\Import\Products as ProductConsole;
use AudereCommerce\AccountsIntegration\Console\Import\MultipleStock as MultipleStockConsole;
use AudereCommerce\AccountsIntegration\Console\Import\Shipments as ShipmentConsole;
use AudereCommerce\AccountsIntegration\Console\Import\Customers as CustomerConsole;

class Import extends SymfonyCommand
{

    /**
     * @var ProductConsole
     */
    protected $_productConsole;

    /**
     * @var MultipleStockConsole
     */
    protected $_multipleStockConsole;

    /**
     * @var ShipmentConsole
     */
    protected $_shipmentConsole;

    /**
     * @var CustomerConsole
     */
    protected $_customerConsole;

    public function __construct(
        ProductConsole $productConsole,
        MultipleStockConsole $multipleStockConsole,
        ShipmentConsole $shipmentConsole,
        CustomerConsole $customerConsole
    )
    {
        $this->_productConsole = $productConsole;
        $this->_multipleStockConsole = $multipleStockConsole;
        $this->_shipmentConsole = $shipmentConsole;
        $this->_customerConsole = $customerConsole;

        parent::__construct('auderecommerce:accountsintegration:import');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return $this
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_productConsole->run($input, $output);
        $this->_multipleStockConsole->run($input, $output);
        $this->_shipmentConsole->run($input, $output);
        $this->_customerConsole->run($input, $output);

        return $this;
    }

}