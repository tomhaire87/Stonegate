<?php

namespace AudereCommerce\Downloads\Model\Download\GroupId;

use AudereCommerce\Downloads\Model\Download\GroupRepository;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{

    /**
     * @var GroupRepository
     */
    protected $_downloadGroupRepository;

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
     * @param GroupRepository $downloadGroupRepository
     */
    public function __construct(SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory, GroupRepository $downloadGroupRepository)
    {
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_downloadGroupRepository = $downloadGroupRepository;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->_options == null) {
            $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
            $searchResults = $this->_downloadGroupRepository->getList($searchCriteriaBuilder->create());

            $options = array();

            foreach ($searchResults->getItems() as $downloadGroup) {
                $options[] = array(
                    'value' => $downloadGroup->getId(),
                    'label' => $downloadGroup->getName()
                );
            }

            $this->_options = $options;
        }

        return $this->_options;
    }
}