<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\RequestForQuote\Block\Cart;

use Magento\Store\Model\ScopeInterface;
/**
 * Cart sidebar block
 *
 * @api
 */
class Sidebar extends \Magento\Checkout\Block\Cart\Sidebar
{
	
	protected function _toHtml() {
		$disable_checkout = $this->getStoreConfig("requestforquote/general/disable_checkout", 0);
		$disable_checkout_guest = $this->getStoreConfig("requestforquote/general/disable_checkout_guest", 0);
		if((bool)$disable_checkout) {
			if($disable_checkout_guest){
				if($this->isGuest()){
					return "";
				}
			} else {
				return "";
			}
		}
		return parent::_toHtml();
	}
	public function getStoreConfig($path, $default = "") {
		$config_value = $this->_scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE
        );
        return $config_value?$config_value:$default;
	}

    public function isGuest()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return false;
        } else {
            return true;
        }
    }
	
}