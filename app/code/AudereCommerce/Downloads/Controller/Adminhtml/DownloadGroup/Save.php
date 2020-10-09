<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;

use AudereCommerce\Downloads\Api\Download\GroupRepositoryInterface;
use AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;
use AudereCommerce\Downloads\Model\Download\GroupFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Save extends DownloadGroup
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_group_save';

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param GroupFactory $groupFactory
     * @param GroupRepositoryInterface $groupRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, GroupFactory $groupFactory, GroupRepositoryInterface $groupRepositoryInterface, PostDataProcessor $dataProcessor, ResourceConnection $resourceConnection)
    {
        $this->_resource = $resourceConnection;
        parent::__construct(
            $context,
            $registry,
            $resultPageFactory,
            $dataPersistor,
            $groupFactory,
            $groupRepositoryInterface,
            $dataProcessor
        );
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data = $this->_postDataProcessor->filter($data);
            $downloadGroupData = $data['download_group'];

            if ($downloadGroupData['id'] == '') {
                $downloadGroupData['id'] = null;
            }

            $id = $downloadGroupData['id'];
            $model = $id ? $this->_groupRepositoryInterface->getById($id) : $this->_groupFactory->create();

            try {
                $model->setData($downloadGroupData);
                $this->_groupRepositoryInterface->save($model);


                $this->messageManager->addSuccessMessage(__('You saved the Download Group'));
                $this->_dataPersistor->clear('download_group');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/', array('id' => $model->getId(), '_current' => true));
                }

                return $resultRedirect->setPath('*/*/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Download Group.'));
            }

            $this->_dataPersistor->set('download_group', $data);
            return $resultRedirect->setPath('*/*/edit', array('id' => $id));
        }

        return $resultRedirect->setPath('*/*/');
    }
}