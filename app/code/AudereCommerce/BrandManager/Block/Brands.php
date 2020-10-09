<?php

namespace AudereCommerce\BrandManager\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use AudereCommerce\BrandManager\Model\BrandRepository;
use AudereCommerce\BrandManager\Api\Data\BrandInterface;

class Brands extends Template
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
     * @param Context $context
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param BrandRepository $brandRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        BrandRepository $brandRepository,
        array $data = []
    )
    {
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_brandRepository = $brandRepository;

        parent::__construct($context, $data);
    }

    /**
     * @return BrandInterface[]
     */
    public function getBrands()
    {
        $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
        $searchResults = $this->_brandRepository->getList($searchCriteriaBuilder->create());

        return $searchResults->getItems();
    }

    /**
     * @param BrandInterface $brand
     * @return string
     */
    public function getBrandImageUrl(BrandInterface $brand)
    {
        return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'brandmanager/brand/' . $brand->getImage();
    }

}