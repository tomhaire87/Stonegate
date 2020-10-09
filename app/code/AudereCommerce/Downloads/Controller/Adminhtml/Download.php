<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml;

use AudereCommerce\Downloads\Api\DownloadRepositoryInterface;
use AudereCommerce\Downloads\Controller\Adminhtml\Download\PostDataProcessor;
use AudereCommerce\Downloads\Model\DownloadFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class Download extends Action
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download';

    /**
     * @var DataPersistorInterface
     */
    protected $_dataPersistor;

    /**
     * @var DownloadFactory
     */
    protected $_downloadFactory;

    /**
     * @var DownloadRepositoryInterface
     */
    protected $_downloadRepositoryInterface;

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
     * @param DownloadFactory $downloadFactory
     * @param DownloadRepositoryInterface $downloadRepositoryInterface
     * @param PostDataProcessor $postDataProcessor
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, DownloadFactory $downloadFactory, DownloadRepositoryInterface $downloadRepositoryInterface, PostDataProcessor $postDataProcessor)
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataPersistor = $dataPersistor;
        $this->_downloadFactory = $downloadFactory;
        $this->_downloadRepositoryInterface = $downloadRepositoryInterface;
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