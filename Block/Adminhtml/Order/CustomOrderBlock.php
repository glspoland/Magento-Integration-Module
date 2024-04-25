<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Block\Adminhtml\Order;

use Magento\Backend\Block\Template\Context;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\Registry;
use Magento\Sales\Block\Adminhtml\Order\AbstractOrder;
use Magento\Sales\Helper\Admin;

class CustomOrderBlock extends AbstractOrder
{
    /** @var CountryFactory */
    protected CountryFactory $countryFactory;

    /**
     * Class constructor.
     *
     * @param CountryFactory $countryFactory
     * @param Context $context
     * @param Registry $registry
     * @param Admin $adminHelper
     */
    public function __construct(
        CountryFactory $countryFactory,
        Context $context,
        Registry $registry,
        Admin $adminHelper
    ) {
        parent::__construct(
            $context,
            $registry,
            $adminHelper
        );

        $this->countryFactory = $countryFactory;
    }

    /**
     * Get country name by country code
     *
     * @param string $countryCode
     * @return string
     */
    public function getCountryName(string $countryCode): string
    {
        return $this->countryFactory->create()->loadByCode($countryCode)->getName();
    }
}
