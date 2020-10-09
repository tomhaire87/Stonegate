<?php

namespace AudereCommerce\BrandManager\Model\Brand\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use AudereCommerce\BrandManager\Model\BrandRepository;

class Product extends Table
{

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @var BrandRepository
     */
    protected $_brandRepository;

    /**
     * @param CollectionFactory $attrOptionCollectionFactory
     * @param OptionFactory $attrOptionFactory
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param BrandRepository $brandRepository
     */
    public function __construct(
        CollectionFactory $attrOptionCollectionFactory,
        OptionFactory $attrOptionFactory,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        BrandRepository $brandRepository
    )
    {
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_brandRepository = $brandRepository;

        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
    }

    /**
     * @return array
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        if (!$this->_options) {
            $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
            $searchResults = $this->_brandRepository->getList($searchCriteriaBuilder->create());

            $options = array();

            foreach ($searchResults->getItems() as $brand) {
                $options[] = array(
                    'label' => $brand->getName(),
                    'value' => $brand->getId()
                );
            }

            $this->_options = $options;
        }

        return $this->_options;
    }

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }

        return false;
    }

}
