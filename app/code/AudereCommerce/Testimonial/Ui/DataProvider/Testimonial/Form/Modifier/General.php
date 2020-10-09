<?php

namespace AudereCommerce\Testimonial\Ui\DataProvider\Testimonial\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Textarea;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class General extends AbstractModifier
{

    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    /**
     * @param UrlInterface $urlInterface
     */
    public function __construct(UrlInterface $urlInterface)
    {
        $this->_urlInterface = $urlInterface;
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
                        'dataScope' => 'data.testimonial'
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
                'company' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'required' => false,
                                'label' => __('Company'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 30
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
                                    'url' => 'testimonial/testimonial/imageUpload'
                                )
                            )
                        )
                    )
                ),
                'testimonial' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Testimonial'),
                                'componentType' => Field::NAME,
                                'formElement' => Textarea::NAME,
                                'source' => 'general',
                                'sortOrder' => 50,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'code' => 'testimonial'
                            )
                        )
                    )
                ),
                'active' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Active'),
                                'componentType' => Field::NAME,
                                'formElement' => Checkbox::NAME,
                                'source' => 'general',
                                'sortOrder' => 60,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'prefer' => 'toggle',
                                'visible' => true,
                                'valueMap' => array(
                                    'true' => '1',
                                    'false' => '0'
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

            $data[$id]['testimonial']['image'] = array(array(
                'url' => $this->_urlInterface->getBaseUrl() . 'catalogue/pub/media/testimonial/testimonial/' . $data[$id]['testimonial']['image'],
                'name' => $data[$id]['testimonial']['image']
            ));
        }

        return $data;
    }
}