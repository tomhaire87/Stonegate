<?php

namespace AudereCommerce\Downloads\Ui\Component\Listing\Column\Download;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class TypeActions extends Column
{

    const PATH_DELETE = 'downloads/downloadtype/delete';

    const PATH_EDIT = 'downloads/downloadtype/edit';

    /**
     * @var string
     */
    protected $_editUrl;

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, UrlInterface $urlBuilder, array $components = array(), array $data = array(), $editUrl = self::PATH_EDIT)
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')]['edit'] = array(
                        'label' => __('Edit'),
                        'href' => $this->_urlBuilder->getUrl($this->_editUrl, array('id' => $item['id']))
                    );
                }
            }
        }

        return $dataSource;
    }
}