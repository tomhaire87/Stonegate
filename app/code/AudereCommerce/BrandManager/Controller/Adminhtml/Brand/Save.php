<?php

namespace AudereCommerce\BrandManager\Controller\Adminhtml\Brand;

use AudereCommerce\BrandManager\Api\BrandRepositoryInterface;
use AudereCommerce\BrandManager\Controller\Adminhtml\Brand;
use AudereCommerce\BrandManager\Model\BrandFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Save extends Brand
{

    const ADMIN_RESOURCE = 'AudereCommerce_BrandManager::brand_save';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param BrandFactory $brandFactory
     * @param BrandRepositoryInterface $brandRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, BrandFactory $brandFactory, BrandRepositoryInterface $brandRepositoryInterface, PostDataProcessor $dataProcessor, ResourceConnection $resourceConnection)
    {
        $this->_resource = $resourceConnection;
        parent::__construct(
            $context,
            $registry,
            $resultPageFactory,
            $dataPersistor,
            $brandFactory,
            $brandRepositoryInterface,
            $dataProcessor
        );
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data = $this->_postDataProcessor->filter($data);
            $brandData = $data['brand'];
            $brandData = $this->imagePreprocessing($brandData);

            if ($brandData['id'] == '') {
                $brandData['id'] = null;
            }

            $id = $brandData['id'];
            $model = $id ? $this->_brandRepositoryInterface->getById($id) : $this->_brandFactory->create();

            try {
                $model->setData($brandData);
                $this->_brandRepositoryInterface->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Brand'));
                $this->_dataPersistor->clear('brand');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/', array('id' => $model->getId(), '_current' => true));
                }

                return $resultRedirect->setPath('*/*/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Brand.'));
            }

            $this->_dataPersistor->set('brand', $data);
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