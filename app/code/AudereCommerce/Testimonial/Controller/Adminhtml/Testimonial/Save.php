<?php

namespace AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;

use AudereCommerce\Testimonial\Api\TestimonialRepositoryInterface;
use AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;
use AudereCommerce\Testimonial\Model\TestimonialFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Save extends Testimonial
{

    const ADMIN_RESOURCE = 'AudereCommerce_Testimonial::testimonial_save';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param TestimonialFactory $testimonialFactory
     * @param TestimonialRepositoryInterface $testimonialRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, TestimonialFactory $testimonialFactory, TestimonialRepositoryInterface $testimonialRepositoryInterface, PostDataProcessor $dataProcessor, ResourceConnection $resourceConnection)
    {
        $this->_resource = $resourceConnection;
        parent::__construct(
            $context,
            $registry,
            $resultPageFactory,
            $dataPersistor,
            $testimonialFactory,
            $testimonialRepositoryInterface,
            $dataProcessor
        );
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data = $this->_postDataProcessor->filter($data);
            $testimonialData = $data['testimonial'];
            $testimonialData = $this->imagePreprocessing($testimonialData);

            if ($testimonialData['id'] == '') {
                $testimonialData['id'] = null;
            }

            $id = $testimonialData['id'];
            $model = $id ? $this->_testimonialRepositoryInterface->getById($id) : $this->_testimonialFactory->create();

            try {
                $model->setData($testimonialData);
                $this->_testimonialRepositoryInterface->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Testimonial'));
                $this->_dataPersistor->clear('testimonial');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/', array('id' => $model->getId(), '_current' => true));
                }

                return $resultRedirect->setPath('*/*/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Testimonial.'));
            }

            $this->_dataPersistor->set('testimonial', $data);
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