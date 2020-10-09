<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use AudereCommerce\SlideManager\Model\SliderFactory;

abstract class Slider extends Action
{

    protected $_registry;
    protected $_resultPageFactory;
    protected $_sliderFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        PageFactory $resultPageFactory,
        SliderFactory $sliderFactory
    )
    {
        parent::__construct($context);

        $this->_registry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_sliderFactory = $sliderFactory;
    }

    protected function _isAllowed()
    {
        return true;
//        return $this->_authorization->isAllowed('AudereCommerce_SlideManager::slider');
    }

}