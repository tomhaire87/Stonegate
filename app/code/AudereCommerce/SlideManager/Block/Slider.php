<?php

namespace AudereCommerce\SlideManager\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Store\Model\StoreManagerInterface;
use \AudereCommerce\SlideManager\Model\System\Config\Location as LocationConfig;
use \AudereCommerce\SlideManager\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;
use \AudereCommerce\SlideManager\Model\ResourceModel\Slide\CollectionFactory as SlideCollectionFactory;

class Slider extends Template
{

    protected $_storeManager;
    protected $_slider;
    protected $_locationConfig;
    protected $_sliderCollectionFactory;
    protected $_slideCollectionFactory;

    /**
     * Slider constructor.
     * @param Context $context
     * @param SliderCollectionFactory $sliderCollectionFactory
     * @param SlideCollectionFactory $slideCollectionFactory
     * @param LocationConfig $locationConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        SliderCollectionFactory $sliderCollectionFactory,
        SlideCollectionFactory $slideCollectionFactory,
        LocationConfig $locationConfig,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->_storeManager = $context->getStoreManager();
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_slideCollectionFactory = $slideCollectionFactory;
        $this->_locationConfig = $locationConfig;
    }

    /**
     * @return \AudereCommerce\SlideManager\Model\Slider
     */
    public function getSlider()
    {
        if (!$this->_slider) {
            $collection = $this->_sliderCollectionFactory->create()
                ->addFieldToFilter('location', $this->getLocation())
                ->addFieldToFilter('status', 1);

            $this->_slider = $collection->getFirstItem();
        }

        return $this->_slider;
    }

    /**
     * @return \AudereCommerce\SlideManager\Model\ResourceModel\Slide\Collection
     */
    public function getSlides()
    {
        $slider = $this->getSlider();

        $collection = $this->_slideCollectionFactory->create()
			->addOrder('position', 'ASC')
            ->addFieldToFilter('slider_id', $slider->getId());

        return $collection;
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

}