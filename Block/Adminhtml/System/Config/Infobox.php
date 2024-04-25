<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Block\Adminhtml\System\Config;

use GlsPoland\Shipping\Config\Config;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Infobox extends Field
{
    /** @var Config */
    protected Config $config;

    /** @var string */
    protected $_template = 'GlsPoland_Shipping::system/config/Infobox.phtml';

    /**
     * InfoBox constructor.
     *
     * @param Context $context
     * @param Config $config
     */
    public function __construct(Context $context, Config $config)
    {
        $this->config = $config;

        parent::__construct($context);
    }

    /**
     * Render element
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $this->element = $element;

        return $this->toHtml();
    }

    /**
     * Return element html
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    /**
     * Get Module version from config.
     *
     * @return string
     */
    public function getModuleVersion(): string
    {
        return (string)$this->config->getModuleVersion();
    }

    /**
     * Get module instruction
     *
     * @return string
     */
    public function getInstructions(): string
    {
        return (string)$this->config->getInstructions();
    }

    /**
     * Get release notes link
     *
     * @return string
     */
    public function getReleaseNotesLink(): string
    {
        return (string)$this->config->getConfigReleaseNotesLink();
    }

    /**
     * Get module version info.
     *
     * @return string
     */
    public function getVersionInformation(): string
    {
        return (string)$this->config->getConfigVersionInformation();
    }
}
