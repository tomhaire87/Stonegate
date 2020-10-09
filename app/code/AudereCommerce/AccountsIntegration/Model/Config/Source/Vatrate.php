<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\Config\Source;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\VatRateRepositoryInterface;
use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ResourceConnection\ConfigInterface as ResourceConfigInterface;

class Vatrate implements ArrayInterface
{

    /**
     * @var SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var VatRateRepositoryInterface
     */
    protected $_vatRateRepository;

    /**
     * @var ResourceConfigInterface
     */
    protected $_config;

    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        VatRateRepositoryInterface $vatRateRepository,
        ResourceConfigInterface $config
    )
    {
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_vatRateRepository = $vatRateRepository;
        $this->_config = $config;
    }

    public function toOptionArray()
    {
        if ($this->_config->getConnectionName('kamarin_ecommerce_link') === \Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION) {
            throw new \Exception('Unable to find the Kamarin Intermediate Tables');
        }

        $options = array();

        $searchCriteria = $this->_searchCriteriaBuilder->create();
        $searchResults = $this->_vatRateRepository->getList($searchCriteria);

        foreach ($searchResults->getItems() as $vatRate) {
            $options[] = array(
                'value' => $vatRate->getVatRateId(),
                'label' => "{$vatRate->getDescription()} ({$vatRate->getCode()})"
            );
        }

        return $options;
    }

}
