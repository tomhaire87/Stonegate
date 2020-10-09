<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slide;
use AudereCommerce\SlideManager\Model\SlideFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;

class Save extends Slide
{

    protected $_filesystem;
    protected $_uploaderFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        PageFactory $resultPageFactory,
        SlideFactory $slideFactory,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory
    )
    {
        $this->_filesystem = $filesystem;
        $this->_uploaderFactory = $uploaderFactory;
        parent::__construct($context, $registry, $resultPageFactory, $slideFactory);
    }

    public function execute()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $model = $this->_slideFactory->create();
            $data = $request->getParam('slide');

            // TODO Remove deprecated load
            if (isset($data['slide_id'])) {
                $model->load($data['slide_id']);
            }

            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] !== '') {
                try {
                    $uploader = $this->_uploaderFactory->create(['fileId' => 'image']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $uploader->setAllowCreateFolders(true);
                    $mediaDir = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                    $result = $uploader->save($mediaDir->getAbsolutePath('slidemanager/images'));

                    $data['image'] = $result['file'];
                } catch (Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            } else {
                unset($data['image']);
            }

            if (isset($_FILES['small_image']['name']) && $_FILES['small_image']['name'] !== '') {
                try {
                    $uploader = $this->_uploaderFactory->create(['fileId' => 'small_image']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $uploader->setAllowCreateFolders(true);
                    $mediaDir = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                    $result = $uploader->save($mediaDir->getAbsolutePath('slidemanager/images'));

                    $data['small_image'] = $result['file'];
                } catch (Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            } else {
                unset($data['small_image']);
            }

            try {
                // TODO Remove deprecated save
                $model->setData($data);
                $model->save();

                // TODO Remove deprecated addSuccess
                $this->messageManager->addSuccess('The slide has been saved.');

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