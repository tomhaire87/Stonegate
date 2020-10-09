<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\Download;

use AudereCommerce\Downloads\Api\DownloadRepositoryInterface;
use AudereCommerce\Downloads\Controller\Adminhtml\Download;
use AudereCommerce\Downloads\Model\DownloadFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Save extends Download
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_save';

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param DownloadFactory $downloadFactory
     * @param DownloadRepositoryInterface $downloadRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, DownloadFactory $downloadFactory, DownloadRepositoryInterface $downloadRepositoryInterface, PostDataProcessor $dataProcessor, ResourceConnection $resourceConnection)
    {
        $this->_resource = $resourceConnection;
        parent::__construct(
            $context,
            $registry,
            $resultPageFactory,
            $dataPersistor,
            $downloadFactory,
            $downloadRepositoryInterface,
            $dataProcessor
        );
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data = $this->_postDataProcessor->filter($data);
            $downloadData = $data['download'];
            $downloadData = $this->filePreprocessing($downloadData);

            if ($downloadData['id'] == '') {
                $downloadData['id'] = null;
            }

            $id = $downloadData['id'];
            $model = $id ? $this->_downloadRepositoryInterface->getById($id) : $this->_downloadFactory->create();

            try {
                $model->setData($downloadData);
                $this->_downloadRepositoryInterface->save($model);

                $this->_saveRelations($model, $data);

                $this->messageManager->addSuccessMessage(__('You saved the Download'));
                $this->_dataPersistor->clear('download');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/', array('id' => $model->getId(), '_current' => true));
                }

                return $resultRedirect->setPath('*/*/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Download.'));
            }

            $this->_dataPersistor->set('download', $data);
            return $resultRedirect->setPath('*/*/edit', array('id' => $id));
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $download
     * @param array $data
     */
    protected function _saveRelations($download, array $data)
    {
        $connection = $this->_resource->getConnection();

        if (isset($data['links'])) {
            $links = $data['links'];

            if (isset($links['product']) && is_array($links['product'])) {
                $table = $connection->getTableName('auderecommerce_downloads_download_product');

                $select = $connection->select()
                    ->from($table)
                    ->where('download_id = ?', $download->getId());

                $connection->query($connection->deleteFromSelect($select, $table));

                foreach ($links['product'] as $product) {
                    $connection->insert($table, array(
                        'download_id' => $download->getId(),
                        'catalog_product_entity_id' => $product['id']
                    ));
                }
            }
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function filePreprocessing(array $data)
    {
        $columns = array(
            'path'
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