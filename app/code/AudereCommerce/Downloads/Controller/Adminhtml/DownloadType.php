<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml;

use AudereCommerce\Downloads\Api\Download\TypeRepositoryInterface;
use AudereCommerce\Downloads\Controller\Adminhtml\DownloadType\PostDataProcessor;
use AudereCommerce\Downloads\Model\Download\TypeFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class DownloadType extends Action
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_type';

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
     * @var TypeFactory
     */
    protected $_typeFactory;

    /**
     * @var TypeRepositoryInterface
     */
    protected $_typeRepositoryInterface;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param TypeFactory $typeFactory
     * @param TypeRepositoryInterface $typeRepositoryInterface
     * @param PostDataProcessor $postDataProcessor
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, TypeFactory $typeFactory, TypeRepositoryInterface $typeRepositoryInterface, PostDataProcessor $postDataProcessor)
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataPersistor = $dataPersistor;
        $this->_typeFactory = $typeFactory;
        $this->_typeRepositoryInterface = $typeRepositoryInterface;
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