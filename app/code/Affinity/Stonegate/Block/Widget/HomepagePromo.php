<?php

namespace Affinity\Stonegate\Block\Widget;

class HomepagePromo extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
	protected $_template = "widget/homepage_promo.phtml";

	/**
	 * Turn this widget's "image" field into usable URL
	 * @return null|string
	 */
	public function getImageUrl()
	{
		if($image = $this->getImage()) {
			$mediaDir	= $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
			return $mediaDir . $image;
		}
		return null;
	}

	/**
	 * Get FQ URL route for identifier
	 * @return null|string
	 */
	public function getBlockUrl()
	{
		if($urlKey = $this->getUrlIdentifier()) {
			return $this->getUrl('', ['_direct' => $urlKey]);
		}
		return null;
	}
}