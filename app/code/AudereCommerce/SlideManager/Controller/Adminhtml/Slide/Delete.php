<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

class Delete extends Slide
{

    public function execute()
    {
        $request = $this->GetRequest();

        if ($id = $request->getParam('id')) {
            $model = $this->_slideFactory->create();
            $model->load($id);

            if (!$model->getId()) {
                // TODO Remove deprecated addError
                $this->messageManager->addError(__('This slide no longer exists.'));
            } else {
                try {
                    // TODO Remove deprecated addSuccess
                    $model->delete();
                    $this->messageManager->addSuccess(__('The slide has been deleted.'));

                    return $this->_redirect('*/*/');
                } catch (\Exception $e) {
                    // TODO Remove deprecated addError
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                }
            }
        }
    }

}