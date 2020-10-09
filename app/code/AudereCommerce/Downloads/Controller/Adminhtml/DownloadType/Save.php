<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

use AudereCommerce\Downloads\Api\Download\TypeRepositoryInterface;
use AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;
use AudereCommerce\Downloads\Model\Download\TypeFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Save extends DownloadType
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_type_save';

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param TypeFactory $typeFactory
     * @param TypeRepositoryInterface $typeRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, TypeFactory $typeFactory, TypeRepositoryInterface $typeRepositoryInterface, PostDataProcessor $dataProcessor, ResourceConnection $resourceConnection)
    {
        $this->_resource = $resourceConnection;
        parent::__construct(
            $context,
            $registry,
            $resultPageFactory,
            $dataPersistor,
            $typeFactory,
            $typeRepositoryInterface,
            $dataProcessor
        );
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data = $this->_postDataProcessor->filter($data);
            $downloadTypeData = $data['download_type'];
            $downloadTypeData = $this->imagePreprocessing($downloadTypeData);

            if ($downloadTypeData['id'] == '') {
                $downloadTypeData['id'] = null;
            }

            $id = $downloadTypeData['id'];
            $model = $id ? $this->_typeRepositoryInterface->getById($id) : $this->_typeFactory->create();

            try {
                $model->setData($downloadTypeData);
                $this->_typeRepositoryInterface->save($model);


                $this->messageManager->addSuccessMessage(__('You saved the Download Type'));
                $this->_dataPersistor->clear('download_type');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/', array('id' => $model->getId(), '_current' => true));
                }

                return $resultRedirect->setPath('*/*/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Download Type.'));
            }

            $this->_dataPersistor->set('download_type', $data);
            return $resultRedirect->setPath('*/*/edit', array('id' => $id));
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param array $data
     * @return array
     */
    public function imagePreprocessing(array $data)
    {
        $columns = array(
            'image'
        );

        foreach ($columns as $column) {
            if (!isset($data[$column])) {
                $data[$column] = false;
            } elseif (isset($data[$column][0]['file'])) {
                $data[$column] = $data[$column][0]['file'];
            } elseif (isset($data[$column][0]['name'])) {
                $data[$column] = $data[$column][0]['name'];
            }
        }

        return $data;
    }
}