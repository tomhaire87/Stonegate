<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_RequestForQuote
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\RequestForQuote\Observer\Frontend;

use Magento\Framework\Event\ObserverInterface;

class CartChangeQty implements ObserverInterface
{

	/**
	 * @var \Magento\Checkout\Model\Session
	 */
	protected $checkoutSession;

	/**
	 * @var \Magento\Quote\Api\CartRepositoryInterface
	 */
	protected $quoteRepository;

	/**
	 * @param \Lof\RequestForQuote\Model\QuoteFactory                    $quoteFactory           
	 * @param \Magento\Quote\Model\ResourceModel\Quote\CollectionFactory $quoteCollectionFactory 
	 * @param \Magento\Store\Model\StoreManagerInterface                 $storeManager           
	 * @param CustomerRepository                                         $customerRepository     
	 * @param \Magento\Checkout\Model\Session                            $checkoutSession        
	 */
	public function __construct(
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Quote\Api\CartRepositoryInterface $quoteRepository
		) {
		$this->checkoutSession        = $checkoutSession;
		$this->quoteRepository        = $quoteRepository;
	}

	public function execute(\Magento\Framework\Event\Observer $observer)
	{
        $request = $observer->getData('request');
        $product = $observer->getProduct();

        /** @var \Magento\Quote\Model\Quote  */
		$quote = $this->checkoutSession->getQuote();
		$useForQuote = $quote->getUseForQuotation();
		if( $useForQuote == 1 ) {
			foreach ($quote->getAllVisibleItems() as $item) {
				$itemOriginalPrice = $item->getOriginalPrice();
				$item->setCustomPrice((float)$itemOriginalPrice);
				$item->setOriginalCustomPrice((float)$itemOriginalPrice);
			}  
		}
		$quote->collectTotals(); 
		$this->quoteRepository->save($quote);
	}
}