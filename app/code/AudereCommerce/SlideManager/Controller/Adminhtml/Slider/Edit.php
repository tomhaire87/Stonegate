<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

class Edit extends Slider
{

    public function execute()
    {
        $model = $this->_sliderFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            // TODO remove deprecated load
            $model->load($id);

            if (!$model->getId()) {
                // TODO remove deprecated addError
                $this->messageManager->addError(__('This slider no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $data = $this->_session->getSliderData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_registry->register('slidemanager_slider', $model);

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Slider Manager'));

        return $resultPage;
    }

}