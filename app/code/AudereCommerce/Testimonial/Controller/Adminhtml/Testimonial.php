<?php

namespace AudereCommerce\Testimonial\Controller\Adminhtml;

use AudereCommerce\Testimonial\Api\TestimonialRepositoryInterface;
use AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial\PostDataProcessor;
use AudereCommerce\Testimonial\Model\TestimonialFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class Testimonial extends Action
{

    const ADMIN_RESOURCE = 'AudereCommerce_Testimonial::testimonial';

    /**
     * @var DataPersistorInterface
     */
    protected $_dataPersistor;

    /**
     * @var PostDataProcessor
     */
    protected $_postDataProcessor;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var TestimonialFactory
     */
    protected $_testimonialFactory;

    /**
     * @var TestimonialRepositoryInterface
     */
    protected $_testimonialRepositoryInterface;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param TestimonialFactory $testimonialFactory
     * @param TestimonialRepositoryInterface $testimonialRepositoryInterface
     * @param PostDataProcessor $postDataProcessor
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, TestimonialFactory $testimonialFactory, TestimonialRepositoryInterface $testimonialRepositoryInterface, PostDataProcessor $postDataProcessor)
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataPersistor = $dataPersistor;
        $this->_testimonialFactory = $testimonialFactory;
        $this->_testimonialRepositoryInterface = $testimonialRepositoryInterface;
        $this->_postDataProcessor = $postDataProcessor;
    }

    /**
     * @return bool
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}