<?php

namespace AudereCommerce\Stonegate\Block\Catalog\Category;

class View extends \Magento\Catalog\Block\Category\View
{

    public function isContentMode()
    {
        return $this->getCurrentCategory()->getIsTopLevel() ? true : parent::isContentMode();
    }

}