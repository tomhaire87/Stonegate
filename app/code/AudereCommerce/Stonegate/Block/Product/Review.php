<?php

namespace AudereCommerce\Stonegate\Block\Product;

class Review extends \Magento\Review\Block\Product\Review
{
    protected $_session;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
        array $data = [],
        \Magento\Customer\Model\Session $session
    ) {
        parent::__construct($context, $registry, $collectionFactory, $data);
        $this->_session = $session;
    }

    public function getSession()
    {
        $session = $this->_session;

        return $session;
    }

}