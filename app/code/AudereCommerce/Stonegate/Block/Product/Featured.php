<?php

namespace AudereCommerce\Stonegate\Block\Product;

class Featured extends \Magento\Framework\View\Element\Template
{
    protected $_postDataHelper;

    protected $_urlHelper;

    protected $_formKey;

    protected $_productCollectionFactory;

    protected $_productVisibility;

    protected $_listProduct;

    protected $_productAttributeCollection;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    protected $_storeManager;

    protected $_featuredGroupLabels = array();

    /* @var $_productVisibilty \Magento\Catalog\Model\Product\Visibility */

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        \Magento\Catalog\Block\Product\ListProduct $listProduct,
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection $productAttributeCollection,
        \Magento\Framework\App\ResourceConnection $resourceConnection
    )
    {
        parent::__construct($context);
        $this->_postDataHelper = $postDataHelper;
        $this->_urlHelper = $urlHelper;
        $this->_formKey = $formKey;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productVisibility = $productVisibility;
        $this->_listProduct = $listProduct;
        $this->_productAttributeCollection = $productAttributeCollection;
        $this->_storeManager = $context->getStoreManager();
        $this->_resource = $resourceConnection;
    }

    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function getFeaturedProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();

        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('is_featured', true)
            ->addStoreFilter($this->getStoreId())
            ->addAttributeToFilter('visibility', array('in' => $this->_productVisibility->getVisibleInCatalogIds()));


        return $collection;
    }

    public function getFeaturedGroupLabels()
    {
        if (!$this->_featuredGroupLabels) {
            $connection = $this->_resource->getConnection();

            $select = $connection->select()
                ->from($connection->getTableName('eav_attribute'))
                ->where('attribute_code = ?', 'featured_group');

            $attributeId = $connection->fetchCol($select, 'attribute_id');

            $select = $connection->select()
                ->from('catalog_product_entity_int')
                ->where('attribute_id = ?', $attributeId);

            $valueIds = array();

            foreach ($connection->fetchAll($select) as $row) {
                $valueIds[$row['value']] = $row['value'];
            }

            $select = $connection->select()
                ->from('eav_attribute_option_value')
                ->where('option_id IN (?)', $valueIds);

            $labels = array();

            foreach ($connection->fetchAll($select) as $row) {
                $labels[$row['value']] = $row['value'];
            }

            $this->_featuredGroupLabels = $labels;
        }

        return $this->_featuredGroupLabels;
    }

    public function getAddToCartPostParams(\Magento\Catalog\Model\Product $_product)
    {
        $url = $this->getAddToCartUrl($_product);
        return [
            'action' => $url,
            'data' => [
                'product' => $_product->getEntityId(),
                \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED =>
                    $this->_urlHelper->getEncodedUrl($url),
            ]
        ];
    }

}