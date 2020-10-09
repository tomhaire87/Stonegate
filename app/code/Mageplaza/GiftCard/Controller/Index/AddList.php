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
 * @package     Mageplaza_GiftCard
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\GiftCard\Controller\Index;

use Exception;
use Magento\Customer\Model\Session as Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Json\Helper\Data as JsonDataHelper;
use Mageplaza\GiftCard\Helper\Customer;
use Mageplaza\GiftCard\Helper\Data as DataHelper;
use Mageplaza\GiftCard\Model\GiftCardFactory;

/**
 * Class AddList
 * @package Magento\Customer\Controller\Ajax
 */
class AddList extends Action
{
    /**
     * @var JsonDataHelper $helper
     */
    protected $helper;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var GiftCardFactory
     */
    protected $giftCardFactory;

    /**
     * @var Customer
     */
    protected $giftCardHelper;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * AddList constructor.
     *
     * @param Context $context
     * @param JsonDataHelper $helper
     * @param JsonFactory $resultJsonFactory
     * @param RawFactory $resultRawFactory
     * @param GiftCardFactory $giftCardFactory
     * @param DataHelper $giftCardHelper
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        JsonDataHelper $helper,
        JsonFactory $resultJsonFactory,
        RawFactory $resultRawFactory,
        GiftCardFactory $giftCardFactory,
        DataHelper $giftCardHelper,
        Session $customerSession
    ) {
        $this->helper = $helper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->giftCardFactory = $giftCardFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->customerSession = $customerSession;
        $this->giftCardHelper = $giftCardHelper;

        parent::__construct($context);
    }

    /**
     * Login registered users and initiate a session.
     *
     * Expects a POST. ex for JSON {"username":"user@magento.com", "password":"userpassword"}
     *
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        $credentials = null;
        $httpBadRequestCode = 400;

        /** @var Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();

        if (!$this->giftCardHelper->isEnabled() || !$this->getRequest()->isAjax()) {
            return $resultRaw->setHttpResponseCode($httpBadRequestCode);
        }

        try {
            $credentials = $this->helper->jsonDecode($this->getRequest()->getContent());
        } catch (Exception $e) {
            return $resultRaw->setHttpResponseCode($httpBadRequestCode);
        }
        if (!$credentials || $this->getRequest()->getMethod() !== 'POST' || !$this->getRequest()->isXmlHttpRequest()) {
            return $resultRaw->setHttpResponseCode($httpBadRequestCode);
        }

        $response = [
            'errors'  => false,
            'message' => __('Invalid Data.')
        ];

        try {
            $giftCard = $this->giftCardFactory->create();
            $giftCard->load($credentials['code'], 'code');

            if (!$giftCard->getId()) {
                throw new LocalizedException(__('Invalid gift card code 223.'));
            }

            $customerId = $this->customerSession->getCustomerId();
            $customerIds = $giftCard->getCustomerIds() ? explode(',', $giftCard->getCustomerIds()) : [];

            if ($credentials['isRemove']) {
                if (($key = array_search($customerId, $customerIds)) !== false) {
                    unset($customerIds[$key]);
                    $response['message'] = __('Gift Card "%1" removed successfully.', $credentials['code']);
                }
            } else {
                if ($giftCard->isActive()) {
                    if (!in_array($customerId, $customerIds)) {
                        $customerIds[] = $customerId;
                    }
                    $response['message'] = __('Gift Card "%1" added successfully.', $credentials['code']);
                } else {
                    throw new LocalizedException(__('Invalid gift card code.'));
                }
            }

            $giftCard->setCustomerIds(implode(',', $customerIds))->save();

            $response['giftCardLists'] = $giftCard->getGiftCardListForCustomer($customerId);
        } catch (LocalizedException $e) {
            $response = [
                'errors'  => true,
                'message' => $e->getMessage()
            ];
        } catch (Exception $e) {
            $response = [
                'errors'  => true,
                'message' => __('Invalid gift card code. %1', $e->getMessage())
            ];
        }
        /** @var Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();

        return $resultJson->setData($response);
    }
}
