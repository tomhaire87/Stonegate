<?php

namespace AudereCommerce\Stonegate\Block;

class Websites extends \Magento\Framework\View\Element\Template
{
    protected $_storeManager;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Directory\Model\Currency $currency,
        array $data = []
    )
    {
        $this->_storeManager = $context->getStoreManager();
        $this->_currency = $currency;
        parent::__construct($context, $data);
    }

    /**
     * Get all stores
     *
     * @return  String
     */
    public function getStores()
    {
        return $this->_storeManager->getStores();
    }

    /**
     * Get current store
     *
     * @return  String
     */
    public function getCurrentStore()
    {
        return $this->_storeManager->getStore();
    }

    /**
     * Get current store currency code
     *
     * @return  String
     */
    public function getCurrentStoreCurrency()
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    public function getStoreCurrency()
    {
        return $this->_storeManager->getCurrentCurrency()->getCode();
    }

    /**
     * Get current store currency symbol
     *
     * @return  String
     */
    public function getCurrentCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    }
}