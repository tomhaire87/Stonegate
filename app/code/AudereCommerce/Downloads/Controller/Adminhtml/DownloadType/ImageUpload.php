<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

use AudereCommerce\Downloads\Api\Download\TypeRepositoryInterface;
use AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;
use AudereCommerce\Downloads\Model\Download\TypeFactory;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class ImageUpload extends DownloadType
{

    /**
     * @var ImageUploader
     */
    protected $_imageUploader;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param TypeFactory $typeFactory
     * @param TypeRepositoryInterface $typeRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ImageUploader $imageUploader
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, TypeFactory $typeFactory, TypeRepositoryInterface $typeRepositoryInterface, PostDataProcessor $dataProcessor, ImageUploader $imageUploader)
    {
        $this->_imageUploader = $imageUploader;
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

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'download_type[image]');

        try {
            $result = $this->_imageUploader->saveFileToTmpDir($imageId);

            $result['cookie'] = array(
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain()
            );
        } catch (\Exception $e) {
            $result = array('error' => $e->getMessage(), 'errorcode' => $e->getCode());
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}