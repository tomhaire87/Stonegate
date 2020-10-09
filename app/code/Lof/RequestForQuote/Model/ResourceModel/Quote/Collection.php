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

namespace Lof\RequestForQuote\Model\ResourceModel\Quote;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lof\RequestForQuote\Model\Quote', 'Lof\RequestForQuote\Model\ResourceModel\Quote');
    }
    public function initDateForFilter(){
        $select_datefield = array('remind_date'  => 'DATE_FORMAT(remind,"%Y-%m-%d")',
                                'expiry_date'  => 'DATE_FORMAT(expiry,"%Y-%m-%d")');

        $this->getSelect()->columns($select_datefield);
        return $this;
    }
    public function addRemindDateForFilter($date_data ) {
        $this->initDateForFilter();
        $this->getSelect()->where('DATE_FORMAT(remind,"%Y-%m-%d") = "'.$date_data.'"');
        return $this;
    }
    public function addExpiryDateForFilter($date_data ) {
        $this->initDateForFilter();
        $this->getSelect()->where('DATE_FORMAT(expiry,"%Y-%m-%d") = "'.$date_data.'"');
        return $this;
    }
}