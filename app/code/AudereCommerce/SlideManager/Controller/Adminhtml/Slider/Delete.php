<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

class Delete extends Slider
{

    public function execute()
    {
        $request = $this->GetRequest();

        if ($id = $request->getParam('id')) {
            $model = $this->_sliderFactory->create();
            $model->load($id);

            if (!$model->getId()) {
                // TODO Remove deprecated addError
                $this->messageManager->addError(__('This slider no longer exists.'));
            } else {
                try {
                    // TODO Remove deprecated addSuccess
                    $model->delete();
                    $this->messageManager->addSuccess(__('The slider has been deleted.'));

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