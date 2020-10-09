<?php

namespace AudereCommerce\Downloads\Model\Download\TypeId;

use AudereCommerce\Downloads\Model\Download\TypeRepository;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{

    /**
     * @var TypeRepository
     */
    protected $_downloadTypeRepository;

    /**
     * @var array
     */
    protected $_options;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param TypeRepository $downloadTypeRepository
     */
    public function __construct(SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory, TypeRepository $downloadTypeRepository)
    {
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_downloadTypeRepository = $downloadTypeRepository;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->_options == null) {
            $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
            $searchResults = $this->_downloadTypeRepository->getList($searchCriteriaBuilder->create());

            $options = array();

            foreach ($searchResults->getItems() as $downloadType) {
                $options[] = array(
                    'value' => $downloadType->getId(),
                    'label' => $downloadType->getName()
                );
            }

            $this->_options = $options;
        }

        return $this->_options;
    }
}