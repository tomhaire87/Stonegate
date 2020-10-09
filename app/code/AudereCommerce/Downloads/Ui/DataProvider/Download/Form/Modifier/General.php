<?php

namespace AudereCommerce\Downloads\Ui\DataProvider\Download\Form\Modifier;

use AudereCommerce\Downloads\Model\Download\GroupId\Options as GroupIdOptions;
use AudereCommerce\Downloads\Model\Download\TypeId\Options as TypeIdOptions;
use AudereCommerce\Downloads\Model\DownloadRepository;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class General extends AbstractModifier
{

    protected $_downloadRepository;

    /**
     * @var GroupIdOptions
     */
    protected $_groupIdOptions;

    /**
     * @var TypeIdOptions
     */
    protected $_typeIdOptions;

    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    /**
     * @param UrlInterface $urlInterface
     * @param DownloadRepository $downloadRepository
     * @param TypeIdOptions $typeIdOptions
     * @param GroupIdOptions $groupIdOptions
     */
    public function __construct(UrlInterface $urlInterface, DownloadRepository $downloadRepository, TypeIdOptions $typeIdOptions, GroupIdOptions $groupIdOptions)
    {
        $this->_urlInterface = $urlInterface;
        $this->_downloadRepository = $downloadRepository;
        $this->_typeIdOptions = $typeIdOptions;
        $this->_groupIdOptions = $groupIdOptions;
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
                        'dataScope' => 'data.download'
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
                'type_id' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Type'),
                                'componentType' => Field::NAME,
                                'formElement' => Select::NAME,
                                'source' => 'general',
                                'sortOrder' => 30,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'options' => $this->_typeIdOptions->toOptionArray()
                            )
                        )
                    )
                ),
                'group_id' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Group'),
                                'componentType' => Field::NAME,
                                'formElement' => Select::NAME,
                                'source' => 'general',
                                'sortOrder' => 40,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'options' => $this->_groupIdOptions->toOptionArray()
                            )
                        )
                    )
                ),
                'path' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('File'),
                                'componentType' => Field::NAME,
                                'formElement' => 'fileUploader',
                                'source' => 'general',
                                'sortOrder' => 50,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'elementTmpl' => 'ui/form/element/uploader/uploader',
                                'previewTmpl' => '',
                                'uploaderConfig' => array(
                                    'url' => 'downloads/download/fileUpload'
                                )
                            )
                        )
                    )
                ),
                'active' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Is Active'),
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
            $download = $this->_downloadRepository->getById($id);

            // File
            $data[$id]['download']['path'] = array(array(
                'url' => $this->_urlInterface->getBaseUrl() . 'catalogue/pub/media/downloads/download/' . $data[$id]['download']['path'],
                'name' => $data[$id]['download']['path']
            ));

            // Relation
            $data[$id]['links']['product'] = array();
            $items = $download->getProducts();

            foreach ($items->getItems() as $item) {
                $data[$id]['links']['product'][] = array(
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'status' => $item->getStatus(),
                    'sku' => $item->getSku()
                );
            }
        }

        return $data;
    }
}