<?php

namespace AudereCommerce\Stonegate\Block;

class StoreInfo extends \Magento\Framework\View\Element\Template
{

    protected $_scopeConfig;

    protected $_cart;

    protected $_currency;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Directory\Model\Currency $currency,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_cart = $cart;
        $this->_currency = $currency;
    }

    /**
     * Get value from Website Config
     *
     * @param String $path
     * @return String
     */
    public function getWebsiteValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE);
    }

    /**
     * Get store email
     *
     * @return String
     */
    public function getStoreEmail()
    {
        return $this->getWebsiteValue('trans_email/ident_general/email');
    }

    /**
     * Get store telephone
     *
     * @return String
     */
    public function getStoreTelephone()
    {
        return $this->getWebsiteValue('general/store_information/phone');
    }

    /**
     * Get store name
     *
     * @return String
     */
    public function getStoreName()
    {
        return $this->getWebsiteValue('general/store_information/name');
    }


    /**
     * Get store address
     *
     * @return String
     */
    public function getStoreAddress()
    {
        return $this->getStoreName() . '<br>' . $this->getWebsiteValue('general/store_information/street_line1') . ', ' . $this->getWebsiteValue('general/store_information/city') . ', ' . $this->getWebsiteValue('general/store_information/region_id') . ', ' . $this->getWebsiteValue('general/store_information/postcode') . ', ' . $this->getWebsiteValue('general/store_information/country_id');
    }

    /**
     * Get store free shopping rate
     *
     * @return String
     */
    public function getFreeShippingRate()
    {
        return $this->getWebsiteValue('carriers/freeshipping/free_shipping_subtotal');
    }

    /**
     * Get store cart total
     *
     * @return String
     */
    public function getCartTotal()
    {
        $cartQuote = $this->_cart->getQuote()->getData();

        return $cartQuote['subtotal'];
    }

    /**
     * Get currency symbol
     *
     * @return String
     */
    public function getCurrentCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    }

}
