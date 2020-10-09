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

namespace Mageplaza\QuickOrder\Controller\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\File\Csv;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem\File\WriteFactory;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Downloadcsv
 * @package Mageplaza\QuickOrder\Controller\Index
 */
class Downloadcsv extends Action
{
    const SAMPLE_QTY = 1;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Csv
     */
    protected $csvProcessor;

    /**
     * @var WriteFactory
     */
    protected $fileWriteFactory;

    /**
     * @var File
     */
    protected $driverFile;

    /**
     * Downloadcsv constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param FileFactory $fileFactory
     * @param Filesystem $filesystem
     * @param Csv $csvProcessor
     * @param WriteFactory $fileWriteFactory
     * @param File $driverFile
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        FileFactory $fileFactory,
        Filesystem $filesystem,
        Csv $csvProcessor,
        WriteFactory $fileWriteFactory,
        File $driverFile
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->fileFactory       = $fileFactory;
        $this->filesystem        = $filesystem;
        $this->csvProcessor      = $csvProcessor;
        $this->fileWriteFactory  = $fileWriteFactory;
        $this->driverFile        = $driverFile;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        $name = md5(microtime());
        $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR)->create('mageplaza_samplecsv');
        $filename = DirectoryList::VAR_DIR . '/mageplaza_samplecsv/' . $name . '.csv';

        $stream = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR)->openFile($filename, 'w+');
        $stream->lock();
        $data = [
            ['SKU', 'QTY', 'Option1:value1', 'Option2:value2'],
            ['MH01', '1', 'size:M', 'color:Gray']
        ];
        $data = array_merge($data, $this->generateSampleData(1));
        foreach ($data as $row) {
            $stream->writeCsv($row);
        }
        $stream->unlock();
        $stream->close();

        return $this->fileFactory->create(
            'mageplaza_qod_sample_csv.csv',
            [
                'type'  => 'filename',
                'value' => $filename,
                'rm'    => true
            ],
            DirectoryList::VAR_DIR
        );
    }

    /**
     * @param $number
     * @return array
     */
    public function generateSampleData($number)
    {
        $data = [];

        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
            ->setPageSize($number)
            ->setCurPage(1);
        foreach ($productCollection as $productModel) {
            $data[] = [$productModel->getData('sku'), self::SAMPLE_QTY, '', ''];
        }

        return $data;
    }
}
