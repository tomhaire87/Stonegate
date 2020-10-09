<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

class Edit extends Slide
{

    public function execute()
    {
        $model = $this->_slideFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            // TODO remove deprecated load
            $model->load($id);

            if (!$model->getId()) {
                // TODO remove deprecated addError
                $this->messageManager->addError(__('This slide no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $data = $this->_session->getSlideData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_registry->register('slidemanager_slide', $model);

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Slide Manager'));

        return $resultPage;
    }

}