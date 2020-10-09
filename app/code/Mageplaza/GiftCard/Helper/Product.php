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

namespace Mageplaza\GiftCard\Helper;

use DateTime;
use DateTimeZone;
use Exception;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Quote\Model\Quote\Item;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\GiftCard\Model\GiftCard\Action;
use Mageplaza\GiftCard\Model\GiftCard\Status;
use Mageplaza\GiftCard\Model\GiftCardFactory;
use Mageplaza\GiftCard\Model\Product\DeliveryMethods;
use Mageplaza\GiftCard\Model\Source\FieldRenderer;

/**
 * Class Product
 * @package Mageplaza\GiftCard\Helper
 */
class Product extends Data
{
    /**
     * value use config
     */
    const VALUE_USE_CONFIG = 'use_config';

    /**
     * @var GiftCardFactory
     */
    protected $_giftCardFactory;

    /**
     * Product constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param TimezoneInterface $localeDate
     * @param GiftCardFactory $giftCardFactory
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        TimezoneInterface $localeDate,
        GiftCardFactory $giftCardFactory
    ) {
        $this->_giftCardFactory = $giftCardFactory;

        parent::__construct($context, $objectManager, $storeManager, $localeDate);
    }

    /**
     * @param \Magento\Sales\Model\Order\Item $orderItem
     * @param null $qty
     *
     * @return $this
     */
    /**
     * @param Order $order
     * @param \Magento\Sales\Model\Order\Item $orderItem
     * @param null $qty
     *
     * @return $this
     */
    public function generateGiftCode($order, $orderItem, $qty = null)
    {
        $options = $orderItem->getProductOptions();

        $giftCardIds = isset($options['giftcards']) ? $options['giftcards'] : [];

        if (sizeof($giftCardIds) >= ($orderItem->getQtyOrdered() - $orderItem->getQtyRefunded())) {
            return $this;
        }

        if (!isset($options[FieldRenderer::AMOUNT]) || !$options[FieldRenderer::AMOUNT]) {
            $this->_logger->error(__(
                'Cannot create gift card from gift product. Item id #%1. Invalid amount.',
                $orderItem->getId()
            ));

            return $this;
        }

        $customerName = $order->getCustomerFirstname() ?: $order->getBillingAddress()->getFirstname();
        $giftCardData = [
            'pattern'            => $options['pattern'],
            'balance'            => $options[FieldRenderer::AMOUNT],
            'status'             => Status::STATUS_ACTIVE,
            'can_redeem'         => $options['can_redeem'],
            'store_id'           => $order->getStoreId(),
            'expire_after'       => $options['expire_after'],
            'template_id'        => isset($options[FieldRenderer::TEMPLATE]) ? $options[FieldRenderer::TEMPLATE] : '',
            'image'              => isset($options[FieldRenderer::IMAGE]) ? $options[FieldRenderer::IMAGE] : '',
            'template_fields'    => [
                'sender'    => isset($options[FieldRenderer::SENDER])
                    ? $options[FieldRenderer::SENDER]
                    : $customerName,
                'recipient' => isset($options[FieldRenderer::RECIPIENT]) ? $options[FieldRenderer::RECIPIENT] : '',
                'message'   => isset($options[FieldRenderer::MESSAGE]) ? $options[FieldRenderer::MESSAGE] : ''
            ],
            'order_item_id'      => $orderItem->getId(),
            'order_increment_id' => $order->getIncrementId(),
            'delivery_method'    => $options[FieldRenderer::METHOD],
            'action_vars'        => [
                'auth'               => $customerName,
                'order_increment_id' => $order->getIncrementId()
            ]
        ];

        switch ($options[FieldRenderer::METHOD]) {
            case DeliveryMethods::METHOD_PRINT:
                $deliveryAddress = $order->getCustomerEmail();
                if (!$order->getCustomerIsGuest()) {
                    $giftCardData['customer_ids'] = $order->getCustomerId();
                }
                break;
            case DeliveryMethods::METHOD_POST:
                /** @var Renderer $addressRender */
                $addressRender = ObjectManager::getInstance()->get(Renderer::class);
                $deliveryAddress = $addressRender->format($order->getShippingAddress(), 'oneline');
                break;
            default:
                $deliveryAddress = isset($options[FieldRenderer::ADDRESS]) ? $options[FieldRenderer::ADDRESS] : '';
                break;
        }
        $giftCardData['delivery_address'] = $deliveryAddress;

        $timezone = null;
        if (isset($options[FieldRenderer::TIMEZONE])) {
            $giftCardData['timezone'] = $options[FieldRenderer::TIMEZONE];
            $timezone = new DateTimeZone($options[FieldRenderer::TIMEZONE]);
        }

        if (isset($options[FieldRenderer::DATE])) {
            $giftCardData['delivery_date'] = $options[FieldRenderer::DATE];
        } elseif ($options[FieldRenderer::METHOD] != DeliveryMethods::METHOD_POST) {
            $giftCardData['delivery_date'] = (new DateTime(null, $timezone))->format('Y-m-d');
            $giftCardData['send_to_recipient'] = true;
        }

        $availableQty = $orderItem->getQtyOrdered() - $orderItem->getQtyRefunded() - sizeof($giftCardIds);
        $qty = is_null($qty) ? $availableQty : min($qty, $availableQty);

        while ($qty--) {
            try {
                $giftCard = $this->_giftCardFactory->create()->addData($giftCardData)->save();
                $giftCardIds[] = $giftCard->getId();
            } catch (Exception $e) {
                $this->_logger->error($e->getMessage());
            }
        }

        $options['giftcards'] = $giftCardIds;
        $orderItem->setProductOptions($options);

        return $this;
    }

    /**
     * @param $orderItem
     * @param $qty
     *
     * @return $this
     */
    public function refundGiftCode($orderItem, $qty)
    {
        if (!$qty) {
            return $this;
        }

        $options = $orderItem->getProductOptions();

        $RefundableGiftCardIds = isset($options['refundable_gift_card']) ? $options['refundable_gift_card'] : [];
        $giftCardIds = isset($options['giftcards']) ? $options['giftcards'] : [];
        if (!($countGiftCard = sizeof($RefundableGiftCardIds))) {
            $this->_logger->error(__('Gift card is not available for refund. Item id #%1', $orderItem->getId()));

            return $this;
        }
        $qty = min($qty, $countGiftCard);
        while ($qty--) {
            $id = array_shift($RefundableGiftCardIds);
            $giftCard = $this->_giftCardFactory->create()->load($id);
            if (!$giftCard->getId()) {
                continue;
            }

            try {
                $giftCard->setStatus(Status::STATUS_CANCELLED)
                    ->setAction(Action::ACTION_REFUND)
                    ->setActionVars(['order_increment_id' => $orderItem->getOrder()->getIncrementId()])
                    ->save();
                $giftCardIds = array_diff($giftCardIds, [$id]);
            } catch (Exception $e) {
                $this->_logger->error($e->getMessage());
            }
        }

        $options['giftcards'] = $giftCardIds;
        $orderItem->setProductOptions($options)->save();

        return $this;
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function getGiftCardCodesFromIds($ids = [])
    {
        $giftCard = $this->_giftCardFactory->create();

        $giftCardCodes = $giftCard->getCollection()
            ->addFieldToFilter('giftcard_id', ['in' => $ids])
            ->getColumnValues('code');

        if (!$this->isAdmin()) {
            foreach ($giftCardCodes as $key => $code) {
                $giftCardCodes[$key] = $giftCard->getHiddenCode($code);
            }
        }

        return $giftCardCodes;
    }

    /**
     * @param $optionCode
     * @param $item
     *
     * @return mixed|string
     */
    protected function getOptionValue($optionCode, $item)
    {
        if ($item instanceof Item) {
            $option = $item->getOptionByCode($optionCode);
            if ($option) {
                return $option->getValue();
            }
        } else {
            $option = $item->getProductOptionByCode($optionCode);
            if ($option) {
                return $option;
            }
        }

        return false;
    }

    /**
     * @param $item
     * @param array $options
     *
     * @return array
     */
    public function getOptionList($item, $options = [])
    {
        $optionList = [];
        $fieldLists = FieldRenderer::getOptionArray();
        $optionShow = explode(',', $this->getProductConfig('checkout/item_renderer'));
        foreach ($optionShow as $option) {
            $value = $this->getOptionValue($option, $item);
            if (!$value) {
                continue;
            }
            switch ($option) {
                case FieldRenderer::AMOUNT:
                    $value = $this->convertPrice($value);
                    break;
                case FieldRenderer::METHOD:
                    $methodOptions = DeliveryMethods::getMethodOptionArray();
                    $value = $methodOptions[$value];
                    break;
                case FieldRenderer::TEMPLATE:
                    $template = $this->getTemplateHelper()->getTemplateById($value);
                    if ($template->getId()) {
                        $value = $template->getName();
                    }
                    break;
            }

            $optionList[] = ['label' => $fieldLists[$option], 'value' => $value, 'custom_view' => true];
        }

        return array_merge($optionList, $options);
    }
}
