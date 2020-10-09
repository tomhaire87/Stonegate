<?php

namespace AudereCommerce\Testimonial\Model;

use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use AudereCommerce\Testimonial\Api\Data\TestimonialInterface;
use AudereCommerce\Testimonial\Api\Data\TestimonialSearchResultsInterface;
use AudereCommerce\Testimonial\Api\TestimonialRepositoryInterface;
use AudereCommerce\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
use AudereCommerce\Testimonial\Model\TestimonialFactory;

class TestimonialRepository implements TestimonialRepositoryInterface
{

    /**
     * @var TestimonialInterface[]
     */
    protected $_instancesById = array();

    /**
     * @var CollectionFactory
     */
    protected $_testimonialCollectionFactory;

    /**
     * @var TestimonialFactory
     */
    protected $_testimonialFactory;

    /**
     * @param CollectionFactory $testimonialCollectionFactory
     * @param TestimonialFactory $testimonialFactory
     */
    public function __construct(CollectionFactory $testimonialCollectionFactory, TestimonialFactory $testimonialFactory)
    {
        $this->_testimonialCollectionFactory = $testimonialCollectionFactory;
        $this->_testimonialFactory = $testimonialFactory;
    }

    /**
     * @param TestimonialInterface $testimonial
     * @return TestimonialInterface
     */
    public function save(TestimonialInterface $testimonial)
    {
        return $testimonial->getResource()->save($testimonial);
    }

    /**
     * @param int $id
     * @param bool $forceReload
     * @return TestimonialInterface
     */
    public function getById($id, $forceReload = false)
    {
        if (!isset($this->_instancesById[$id]) || $forceReload) {
            $model = $this->_testimonialFactory->create();
            $model->load($id);

            if (!$model->getId()) {
                throw NoSuchEntityException::singleField('id', $id);
            }

            $this->_instancesById[$id] = $model;
        }

        return $this->_instancesById[$id];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TestimonialSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $testimonialCollection = $this->_testimonialCollectionFactory->create();
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $testimonialCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $testimonialCollection;
    }

    /**
     * @param TestimonialInterface $testimonial
     * @return bool
     */
    public function delete(TestimonialInterface $testimonial)
    {
        $id = $testimonial->getId();

        try {
            unset($this->_instancesById[$id]);
            $testimonial->getResource()->delete($testimonial);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(__('Unable to remove %1', $id));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        $model = $this->getById($id);
        return $this->delete($model);
    }
}