<?php

namespace AudereCommerce\TradeAccount\Block;

class Request extends \Magento\Framework\View\Element\Template
{

    public function _prepareLayout()
    {
        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle('Request Trade');
        }

        return parent::_prepareLayout();
    }

}
