<?php

namespace AudereCommerce\BrandManager\Ui\DataProvider\Brand\Form;

use AudereCommerce\BrandManager\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class BrandDataProvider extends AbstractDataProvider
{

    /**
     * @var PoolInterface
     */
    private $_pool;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param PoolInterface $pool
     * @param array $meta
     * @param array $data
     */
    public function __construct($name, $primaryFieldName, $requestFieldName, CollectionFactory $collectionFactory, PoolInterface $pool, array $meta = array(), array $data = array())
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->_pool = $pool;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        foreach ($this->_pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }

    /**
     * @return array
     */
    public function getData()
    {
        foreach ($this->getCollection() as $item) {
            $this->data[$item->getId()]['brand'] = $item->getData();
        }

        foreach ($this->_pool->getModifiersInstances() as $modifier) {
            $this->data = $modifier->modifyData($this->data);
        }

        return $this->data;
    }
}