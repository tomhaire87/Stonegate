<?php

namespace AudereCommerce\Downloads\Ui\DataProvider\Download\Type\Form\Modifier;

use AudereCommerce\Downloads\Model\Download\TypeRepository;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class General extends AbstractModifier
{

    protected $_typeRepository;

    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    /**
     * @param UrlInterface $urlInterface
     * @param TypeRepository $typeRepository
     */
    public function __construct(UrlInterface $urlInterface, TypeRepository $typeRepository)
    {
        $this->_urlInterface = $urlInterface;
        $this->_typeRepository = $typeRepository;
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $meta['general'] = array(
            'arguments' => array(
                'data' => array(
                    'config' => array(
                        'componentType' => Fieldset::NAME,
                        'label' => __('General'),
                        'sortOrder' => 10,
                        'collapsible' => true,
                        'dataScope' => 'data.download_type'
                    )
                )
            ),
            'children' => array(
                'id' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'formElement' => 'hidden',
                                'label' => __('id'),
                                'componentType' => Field::NAME,
                                'source' => 'general',
                                'sortOrder' => 10
                            )
                        )
                    )
                ),
                'name' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Name'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 20,
                                'validation' => array(
                                    'required-entry' => '1'
                                )
                            )
                        )
                    )
                ),
                'image' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Image'),
                                'componentType' => Field::NAME,
                                'formElement' => 'fileUploader',
                                'source' => 'general',
                                'sortOrder' => 30,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'elementTmpl' => 'ui/form/element/uploader/uploader',
                                'previewTmpl' => 'Magento_Catalog/image-preview',
                                'uploaderConfig' => array(
                                    'url' => 'downloads/downloadType/imageUpload'
                                )
                            )
                        )
                    )
                )
            )
        );

        return $meta;
    }

    /**
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        if (!empty($data)) {
            $id = array_keys($data)[0];
            $type = $this->_typeRepository->getById($id);

            // File
            $data[$id]['download_type']['image'] = array(array(
                'url' => $this->_urlInterface->getBaseUrl() . 'catalogue/pub/media/downloads/download/type/' . $data[$id]['download_type']['image'],
                'name' => $data[$id]['download_type']['image']
            ));
        }

        return $data;
    }
}