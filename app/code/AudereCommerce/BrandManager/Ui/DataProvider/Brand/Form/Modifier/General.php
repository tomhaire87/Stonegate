<?php

namespace AudereCommerce\BrandManager\Ui\DataProvider\Brand\Form\Modifier;

use AudereCommerce\BrandManager\Model\Brand\CategoryId\Options as CategoryIdOptions;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\Textarea;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class General extends AbstractModifier
{

    /**
     * @var CategoryIdOptions
     */
    protected $_categoryIdOptions;

    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    /**
     * @param UrlInterface $urlInterface
     * @param CategoryIdOptions $categoryIdOptions
     */
    public function __construct(UrlInterface $urlInterface, CategoryIdOptions $categoryIdOptions)
    {
        $this->_urlInterface = $urlInterface;
        $this->_categoryIdOptions = $categoryIdOptions;
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
                        'dataScope' => 'data.brand'
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
                'description' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Description'),
                                'componentType' => Field::NAME,
                                'formElement' => Textarea::NAME,
                                'source' => 'general',
                                'sortOrder' => 30,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'code' => 'description'
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
                                'sortOrder' => 40,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'elementTmpl' => 'ui/form/element/uploader/uploader',
                                'previewTmpl' => 'Magento_Catalog/image-preview',
                                'uploaderConfig' => array(
                                    'url' => 'brandmanager/brand/imageUpload'
                                )
                            )
                        )
                    )
                ),
                'category_id' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Category'),
                                'componentType' => Field::NAME,
                                'formElement' => Select::NAME,
                                'source' => 'general',
                                'sortOrder' => 50,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'options' => $this->_categoryIdOptions->toOptionArray()
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

            $data[$id]['brand']['image'] = array(array(
                'url' => $this->_urlInterface->getBaseUrl() . 'catalogue/pub/media/brandmanager/brand/' . $data[$id]['brand']['image'],
                'name' => $data[$id]['brand']['image']
            ));
        }

        return $data;
    }
}