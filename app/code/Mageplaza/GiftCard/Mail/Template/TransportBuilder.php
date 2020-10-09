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

namespace Mageplaza\GiftCard\Mail\Template;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Mail\Template\TransportBuilder as DefaultBuilder;
use Mageplaza\GiftCard\Helper\Data;
use Zend\Mime\Part;
use Zend_Mime;

/**
 * Class TransportBuilder
 * @package Mageplaza\GiftCard\Mail\Template
 */
class TransportBuilder extends DefaultBuilder
{
    /**
     * Attachment name
     */
    const ATTACHMENT_NAME = 'gift_card.pdf';

    /**
     * @param $attachFile
     * @param string $mimeType
     * @param string $disposition
     * @param string $encoding
     * @param string $filename
     *
     * @return $this|Part
     */
    public function addAttachment(
        $attachFile,
        $mimeType = 'application/pdf',
        $disposition = Zend_Mime::DISPOSITION_ATTACHMENT,
        $encoding = Zend_Mime::ENCODING_BASE64,
        $filename = self::ATTACHMENT_NAME
    ) {
        $objectManager = ObjectManager::getInstance();
        $helper = $objectManager->get(Data::class);
        if ($helper->versionCompare('2.2.8')) {
            $attachment = new Part($attachFile);
            $attachment->type = $mimeType;
            $attachment->encoding = $encoding;
            $attachment->disposition = $disposition;
            $attachment->filename = $filename;

            return $attachment;
        }
        $this->message->createAttachment($attachFile, $mimeType, $disposition, $encoding, $filename);

        return $this;
    }
}
