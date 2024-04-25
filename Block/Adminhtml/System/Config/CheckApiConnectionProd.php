<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class CheckApiConnectionProd extends Field
{
    /** @var string */
    protected $_template = 'GlsPoland_Shipping::system/config/CheckApiConnectionProd.phtml';

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
     * Get url for ajax request
     *
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->getUrl('gls_poland/apiconnection/check');
    }
}
