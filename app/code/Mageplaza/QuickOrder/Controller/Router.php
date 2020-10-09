<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_QuickOrder
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\QuickOrder\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Route\ConfigInterface;
use Magento\Framework\App\Router\ActionList;
use Magento\Framework\App\RouterInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\QuickOrder\Helper\Data;

/**
 * Class Router
 * @package Mageplaza\QuickOrder\Controller
 */
class Router implements RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * @var \Magento\Framework\App\Router\ActionList
     */
    private $actionList;

    /**
     * @var \Mageplaza\QuickOrder\Helper\Data
     */
    protected $_helperData;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ConfigInterface
     */
    protected $routeConfig;

    /**
     * Router constructor.
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\Route\ConfigInterface $routeConfig
     * @param \Magento\Framework\App\Router\ActionList $actionList
     * @param \Mageplaza\QuickOrder\Helper\Data $helperData
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        ActionFactory $actionFactory,
        ConfigInterface $routeConfig,
        ActionList $actionList,
        Data $helperData,
        StoreManagerInterface $storeManager
    )
    {
        $this->actionFactory = $actionFactory;
        $this->routeConfig   = $routeConfig;
        $this->actionList    = $actionList;
        $this->_helperData   = $helperData;
        $this->_storeManager = $storeManager;
    }

    /**
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        if ($identifier !== $this->_helperData->getUrlSuffix()) {
            if ($identifier != 'quickorder' && $identifier != 'quickorder/index/index') {
                return null;
            }
        }

        $modules = $this->routeConfig->getModulesByFrontName('quickorder');
        if (empty($modules)) {
            return null;
        }

        $actionClassName = $this->actionList->get($modules[0], null, 'index', 'index');
        $actionInstance  = $this->actionFactory->create($actionClassName);

        return $actionInstance;
    }
}
