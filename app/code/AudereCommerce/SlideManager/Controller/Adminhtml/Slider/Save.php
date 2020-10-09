<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

class Save extends Slider
{

    public function execute()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $model = $this->_sliderFactory->create();
            $data = $request->getParam('slider');

            // TODO Remove deprecated load
            if (isset($data['slider_id'])) {
                $model->load($data['slider_id']);
            }

            try {
                // TODO Remove deprecated save
                $model->setData($data);
                $model->save();

                // TODO Remove deprecated addSuccess
                $this->messageManager->addSuccess('The slider has been saved.');

                if ($request->getParam('back')) {
                    return $this->_redirect('*/*/edit', array(
                        'id' => $model->getId(),
                        '_current' => true
                    ));
                }

                return $this->_redirect('*/*/');

            } catch (Exception $e) {
                // TODO Remove deprecated addError
                $this->messageManager->addError($e->getMessage());
            }

            $this->_getSession()->setFormData($data);
        }

        return $this->_redirect('*/*/edit', array('id' => $model->getId()));
    }

}