<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_RequestForQuote
 * @copyright  Copyright (c) 2017 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\RequestForQuote\Plugin\Checkout\Controller;
use Magento\Framework\Exception\NotFoundException;
class Cart
{
     /**
     * Url builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * rfq helper
     *
     * @var \Lof\RequestForQuote\Helper\Data
     */
    protected $_helperData;
    protected $_customerSession;

    public function __construct(
        \Lof\RequestForQuote\Helper\Data $_helperData,
        \Magento\Framework\UrlInterface $url,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->_helperData = $_helperData;
        $this->url = $url;
        $this->_customerSession = $customerSession;
    }
    public function beforeDispatch(\Magento\Checkout\Controller\Cart $subject, \Magento\Framework\App\RequestInterface $request)
    {
        $disable_addtocart = $this->_helperData->getConfig("general/disable_addtocart", 0);
        $disable_checkout_guest = $this->_helperData->getConfig("general/disable_checkout_guest", 0);
        $controller = $request->getControllerName();
        $module = $request->getModuleName();
        if((bool)$disable_addtocart && $controller == 'cart' && $module == 'checkout') {
            if($disable_checkout_guest){
                if($this->isGuest()){
                    throw new NotFoundException(__('Page not found.'));
                    return;
                }
            } else {
                throw new NotFoundException(__('Page not found.'));
                return;
            }
            
        }
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
?>