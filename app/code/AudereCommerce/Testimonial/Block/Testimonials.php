<?php

namespace AudereCommerce\Testimonial\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use AudereCommerce\Testimonial\Model\TestimonialRepository;
use AudereCommerce\Testimonial\Api\Data\TestimonialInterface;
use Magento\Framework\UrlInterface;

class Testimonials extends Template
{

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @var TestimonialRepository
     */
    protected $_testimonialRepository;

    /**
     * @param Context $context
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param TestimonialRepository $testimonialRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        TestimonialRepository $testimonialRepository,
        array $data = []
    )
    {
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_testimonialRepository = $testimonialRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return TestimonialInterface[]
     */
    public function getTestimonials()
    {
        $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
        $searchCriteriaBuilder->addFilter('active', true);

        $searchResults = $this->_testimonialRepository->getList($searchCriteriaBuilder->create());

        return $searchResults->getItems();
    }

    /**
     * @param TestimonialInterface $testimonial
     * @return string
     */
    public function getTestimonialImage(TestimonialInterface $testimonial)
    {
        return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'testimonial/testimonial/' . $testimonial->getImage();
    }

}
