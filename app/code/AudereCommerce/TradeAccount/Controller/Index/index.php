<?php

namespace AudereCommerce\TradeAccount\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\View;

class Index extends Action
{
    
    protected $_view;
    /* @var $_view View */
    
    public function __construct(
            Context $context
        )
    {
        $this->_view = $context->getView();
        
        parent::__construct($context);
    }
    
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

}
