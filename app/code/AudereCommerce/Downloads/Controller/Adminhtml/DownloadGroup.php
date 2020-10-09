<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml;

use AudereCommerce\Downloads\Api\Download\GroupRepositoryInterface;
use AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup\PostDataProcessor;
use AudereCommerce\Downloads\Model\Download\GroupFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class DownloadGroup extends Action
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_group';

    /**
     * @var DataPersistorInterface
     */
    protected $_dataPersistor;

    /**
     * @var GroupFactory
     */
    protected $_groupFactory;

    /**
     * @var GroupRepositoryInterface
     */
    protected $_groupRepositoryInterface;

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
     * @param GroupFactory $groupFactory
     * @param GroupRepositoryInterface $groupRepositoryInterface
     * @param PostDataProcessor $postDataProcessor
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, GroupFactory $groupFactory, GroupRepositoryInterface $groupRepositoryInterface, PostDataProcessor $postDataProcessor)
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataPersistor = $dataPersistor;
        $this->_groupFactory = $groupFactory;
        $this->_groupRepositoryInterface = $groupRepositoryInterface;
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