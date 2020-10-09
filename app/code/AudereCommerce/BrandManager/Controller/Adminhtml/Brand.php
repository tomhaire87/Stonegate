<?php

namespace AudereCommerce\BrandManager\Controller\Adminhtml;

use AudereCommerce\BrandManager\Api\BrandRepositoryInterface;
use AudereCommerce\BrandManager\Controller\Adminhtml\Brand\PostDataProcessor;
use AudereCommerce\BrandManager\Model\BrandFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class Brand extends Action
{

    const ADMIN_RESOURCE = 'AudereCommerce_BrandManager::brand';

    /**
     * @var BrandFactory
     */
    protected $_brandFactory;

    /**
     * @var BrandRepositoryInterface
     */
    protected $_brandRepositoryInterface;

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
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param BrandFactory $brandFactory
     * @param BrandRepositoryInterface $brandRepositoryInterface
     * @param PostDataProcessor $postDataProcessor
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, BrandFactory $brandFactory, BrandRepositoryInterface $brandRepositoryInterface, PostDataProcessor $postDataProcessor)
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataPersistor = $dataPersistor;
        $this->_brandFactory = $brandFactory;
        $this->_brandRepositoryInterface = $brandRepositoryInterface;
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