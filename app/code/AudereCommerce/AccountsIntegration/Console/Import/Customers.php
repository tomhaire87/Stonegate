<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console\Import;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AudereCommerce\AccountsIntegration\Console\Import\Customers\Customer as CustomerConsole;
use AudereCommerce\AccountsIntegration\Console\Import\Customers\SpecialPrices as SpecialPricesConsole;
use AudereCommerce\AccountsIntegration\Console\Import\Customers\Discounts as DiscountsConsole;

class Customers extends SymfonyCommand
{

    /**
     * @var CustomerConsole
     */
    protected $_customerConsole;

    /**
     * @var SpecialPricesConsole
     */
    protected $_specialPricesConsole;

    /**
     * @var DiscountsConsole
     */
    protected $_discountsConsole;

    public function __construct(
        CustomerConsole $customerConsole,
        SpecialPricesConsole $specialPricesConsole,
        DiscountsConsole $discountsConsole
    )
    {
        $this->_customerConsole = $customerConsole;
        $this->_specialPricesConsole = $specialPricesConsole;
        $this->_discountsConsole = $discountsConsole;

        parent::__construct('auderecommerce:accountsintegration:import:customers');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return $this
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_customerConsole->run($input, $output);
        $this->_specialPricesConsole->run($input, $output);
        $this->_discountsConsole->run($input, $output);

        return $this;
    }

}