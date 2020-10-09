<?php

namespace Affinity\Stonegate\Block\Widget;

class HomepagePromoBanner extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
	protected $_template = "widget/homepage_promo_banner.phtml";

	/**
	 * Get FQ URL route for identifier
	 * @return null|string
	 */
	public function getButtonUrl()
	{
		if($urlKey = $this->getUrlIdentifier()) {
			return $this->getUrl('', ['_direct' => $urlKey]);
		}
		return null;
	}
}