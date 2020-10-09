<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_XmlSitemap
 */


namespace Amasty\XmlSitemap\Block\Adminhtml\Sitemap\Edit\Tab;

class Navigation extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Config\Model\Config\Source\YesnoFactory $yesnoFactory
     */
    private $yesnoFactory;

    /**
     * @var \Amasty\XmlSitemap\Helper\Data $helper
     */
    private $helper;

    /**
     * @var \Magento\Framework\Module\Manager $moduleManager
     */
    private $moduleManager;

    /**
     * Landing constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Config\Model\Config\Source\YesnoFactory $yesnoFactory
     * @param \Amasty\XmlSitemap\Helper\Data $helper
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Source\YesnoFactory $yesnoFactory,
        \Amasty\XmlSitemap\Helper\Data $helper,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->yesnoFactory = $yesnoFactory;
        $this->helper = $helper;
        $this->moduleManager = $moduleManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Include Improved Navigation Pages');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Include Improved Navigation Pages');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return !$this->moduleManager->isEnabled('Amasty_Shopby');
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('amxmlsitemap_profile');

        $yesno = $this->yesnoFactory->create()->toOptionArray();

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('amxmlsitemap_form_navigation', ['legend' => __('Improved Navigation Pages')]);

        $fieldset->addField('navigation', 'select', [
            'label' => __('Include Improved Navigation Pages'),
            'name' => 'navigation',
            'title' => __('Include Improved Navigation Pages'),
            'values' => $yesno
        ]);

        $fieldset->addField('navigation_priority', 'text', [
            'label' => __('Priority'),
            'name' => 'navigation_priority',
            'note' => __('0.01-0.99'),
            'class' => 'validate-number validate-number-range number-range-0.01-0.99'
        ]);

        $fieldset->addField('navigation_frequency', 'select', [
            'label' => __('Frequency'),
            'name' => 'navigation_frequency',
            'title' => __('Frequency'),
            'values' => $this->helper->getFrequency()
        ]);

        $form->addValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
