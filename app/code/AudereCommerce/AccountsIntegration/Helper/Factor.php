<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Helper;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;

class Factor extends AbstractHelper
{

    /**
     * @var ProductResource
     */
    protected $_productResource;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        ProductResource $productResource
    )
    {
        $this->_productResource = $productResource;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isFactorEnabled()
    {
        return $this->scopeConfig->getValue('auderecommerce_accountsintegration/factor/enable');
    }

    /**
     * @return null|string
     */
    public function getFactorAttribute()
    {
        return $this->scopeConfig->getValue('auderecommerce_accountsintegration/factor/attribute');
    }

    /**
     * @return null|string
     */
    public function getFactorType()
    {
        return $this->scopeConfig->getValue('auderecommerce_accountsintegration/factor/type');
    }

    /**
     * Get product factor value
     *
     * @param ProductInterface $product
     * @return float
     */
    public function getProductFactor(ProductInterface $product)
    {
        if ($factorAttribute = $this->getFactorAttribute()) {
            if ($attribute = $this->_productResource->getAttribute($factorAttribute)) {
                if ($factor = (float)$attribute->getFrontend()->getValue($product)) {
                    return $factor;
                }
            }
        }

        return $this->scopeConfig->getValue('auderecommerce_accountsintegration/factor/default');
    }

    /**
     * Get import price
     *
     * @param float $price
     * @param float $factor
     * @return float
     */
    public function getImportPrice($price, $factor)
    {
        $factor = max(1, $factor);

        switch ($this->getFactorType()) {
            case \AudereCommerce\AccountsIntegration\Model\Config\Source\Factor\Type::OPTION_DIVIDE_PRICE_DIVIDE_QUANTITY:
                $price = $price / $factor;
                break;
            case \AudereCommerce\AccountsIntegration\Model\Config\Source\Factor\Type::OPTION_MULTIPLY_PRICE_MULTIPLY_QUANTITY:
                $price = $price * $factor;
                break;
        }

        return $price;
    }

    /**
     * Get export quantity
     *
     * @param float $quantity
     * @param float $factor
     * @return float
     */
    public function getExportQuantity($quantity, $factor)
    {
        $factor = max(1, $factor);

        switch ($this->getFactorType()) {
            case \AudereCommerce\AccountsIntegration\Model\Config\Source\Factor\Type::OPTION_DIVIDE_PRICE_DIVIDE_QUANTITY:
                $quantity = $quantity / $factor;
                break;
            case \AudereCommerce\AccountsIntegration\Model\Config\Source\Factor\Type::OPTION_MULTIPLY_PRICE_MULTIPLY_QUANTITY:
                $quantity = $quantity * $factor;
                break;
        }

        return $quantity;
    }

    /**
     * Remove factor applied by getExportQuantity
     *
     * @see getExportQuantity
     * @param float $quantity
     * @param float $factor
     * @return float
     */
    public function getOriginalExportQuantity($quantity, $factor)
    {
        $factor = max(1, $factor);

        switch ($this->getFactorType()) {
            case \AudereCommerce\AccountsIntegration\Model\Config\Source\Factor\Type::OPTION_DIVIDE_PRICE_DIVIDE_QUANTITY:
                $quantity = $quantity * $factor;
                break;
            case \AudereCommerce\AccountsIntegration\Model\Config\Source\Factor\Type::OPTION_MULTIPLY_PRICE_MULTIPLY_QUANTITY:
                $quantity = $quantity / $factor;
                break;
        }

        return $quantity;
    }

}