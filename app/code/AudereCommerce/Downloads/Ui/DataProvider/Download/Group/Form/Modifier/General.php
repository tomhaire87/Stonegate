<?php

namespace AudereCommerce\Downloads\Ui\DataProvider\Download\Group\Form\Modifier;

use AudereCommerce\Downloads\Model\Download\GroupRepository;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class General extends AbstractModifier
{

    protected $_groupRepository;

    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    /**
     * @param UrlInterface $urlInterface
     * @param GroupRepository $groupRepository
     */
    public function __construct(UrlInterface $urlInterface, GroupRepository $groupRepository)
    {
        $this->_urlInterface = $urlInterface;
        $this->_groupRepository = $groupRepository;
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
                        'dataScope' => 'data.download_group'
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
                'url_key' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('URL Key'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 30,
                                'validation' => array(
                                    'required-entry' => '1'
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
            $group = $this->_groupRepository->getById($id);


        }

        return $data;
    }
}