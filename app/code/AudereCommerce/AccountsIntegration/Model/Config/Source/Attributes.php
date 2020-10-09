<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Eav\Api\AttributeRepositoryInterface;

class Attributes implements ArrayInterface
{

    /**
     * @var SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var AttributeRepositoryInterface
     */
    protected $_attributeRepository;

    /**
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        AttributeRepositoryInterface $attributeRepository
    )
    {
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_attributeRepository = $attributeRepository;
    }

    public function toOptionArray()
    {
        $searchCriteria = $this->_searchCriteriaBuilder->create();
        $searchResults = $this->_attributeRepository->getList('catalog_product', $searchCriteria);

        $options = array();

        $options[] = array('value' => 0, 'label' => '(No Value)');

        foreach ($searchResults->getItems() as $attribute) {
            if (!$attribute->getIsUserDefined() && !in_array($attribute->getAttributeCode(), array('meta_title', 'meta_description', 'meta_keyword', 'weight'))) {
                continue;
            }

            $options[] = array(
                'value' => $attribute->getAttributeCode(),
                'label' => $attribute->getFrontendLabel()
            );
        }

        return $options;
    }

}
