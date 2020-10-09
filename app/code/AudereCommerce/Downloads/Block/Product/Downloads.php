<?php

namespace AudereCommerce\Downloads\Block\Product;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use AudereCommerce\Downloads\Model\Download\GroupRepository;
use AudereCommerce\Downloads\Api\Data\Download\GroupInterface;

class Downloads extends \Magento\Catalog\Block\Product\View
{

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @var GroupRepository
     */
    protected $_groupRepository;

    /**
     * @param Context $context
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param GroupRepository $groupRepository
     * @param array $data
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        GroupRepository $groupRepository,
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        array $data = array()
    )
    {
        $this->_resource = $resourceConnection;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_groupRepository = $groupRepository;
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    /**
     * @param ProductInterface $product
     * @return GroupInterface[]
     */
    public function getDownloadGroups(ProductInterface $product)
    {
        $connection = $this->_resource->getConnection();

        $select = $connection->select()
            ->from($connection->getTableName('auderecommerce_downloads_download_product'))
            ->where('catalog_product_entity_id = ?', $product->getId());

        $downloadIds = array();

        foreach ($connection->fetchAll($select) as $relation) {
            $downloadIds[$relation['download_id']] = $relation['download_id'];
        }

        $select = $connection->select()
            ->from('auderecommerce_downloads_download')
            ->where('id in (?)', $downloadIds);

        $groupIds = array();

        foreach ($connection->fetchAll($select) as $download) {
            $groupIds[$download['group_id']] = $download['group_id'];
        }

        $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
        $searchCriteria = $searchCriteriaBuilder
            ->addFilter('id', $groupIds, 'in')
            ->create();

        $downloadsGroups = $this->_groupRepository->getList($searchCriteria);

        return $downloadsGroups->getItems();
    }

}