<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_Meta
 */

namespace Amasty\Meta\Controller\Adminhtml\Custom;
use Magento\Framework\App\ResponseInterface;

class Delete extends \Amasty\Meta\Controller\Adminhtml\Config\Delete
{

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        parent::execute();
    }
}
