<?php

namespace Affinity\OfflineOrders\Controller\Index;

class View extends AbstractOfflineOrder
{
	/**
	 * @var \Magento\Framework\View\Result\PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Customer\Model\Session $customerSession,
		\Affinity\OfflineOrders\Model\OrderFactory $orderFactory,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	) {
		$this->resultPageFactory = $resultPageFactory;
		parent::__construct($context, $customerSession, $orderFactory);
	}

	/**
	 * @return \Magento\Framework\App\ResponseInterface
	 */
	public function execute()
	{
		if (!$this->_canViewOrder()) return $this->_redirect('offlineorders');

		/** @var Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->set(__('Offline Orders'));

		return $resultPage;
	}
}