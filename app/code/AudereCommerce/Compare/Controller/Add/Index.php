<?php

namespace AudereCommerce\Compare\Controller\Add;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Visitor;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\Product\Compare\ListCompare;
use Magento\Catalog\Helper\Product\Compare;

class Index extends Action
{

    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var Visitor
     */
    protected $_visitor;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var ListCompare
     */
    protected $_listCompare;

    /**
     * @var Compare
     */
    protected $_compare;

    /**
     * @param Context $context
     * @param Session $session
     * @param Visitor $visitor
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param ProductRepository $productRepository
     * @param ListCompare $listCompare
     * @param Compare $compare
     */
    public function __construct(
        Context $context,
        Session $session,
        Visitor $visitor,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        ProductRepository $productRepository,
        ListCompare $listCompare,
        Compare $compare
    )
    {
        $this->_session = $session;
        $this->_visitor = $visitor;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_productRepository = $productRepository;
        $this->_listCompare = $listCompare;
        $this->_compare = $compare;
        parent::__construct($context);
    }

    public function execute()
    {
//        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->_visitor->getId() || $this->_session->isLoggedIn()) {
            $productIds = $this->getRequest()->getParam('products');

            if ($productIds) {
                $productIds = explode(',', $productIds);

                $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
                $searchCriteriaBuilder->addFilter('entity_id', $productIds, 'in');

                $searchResult = $this->_productRepository->getList($searchCriteriaBuilder->create());

                if ($searchResult->getTotalCount()) {
                    foreach ($searchResult->getItems() as $product) {
                        $this->_listCompare->addProduct($product);
                        $this->_eventManager->dispatch('catalog_product_compare_add_product', ['product' => $product]);
                        $this->_compare->calculate();
                    }

                    $this->messageManager->addSuccessMessage(__('You added products to the comparison list.'));
                }
            }
        }
//        return $resultRedirect->setRefererOrBaseUrl();
    }

}
