<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Plugin;

use Magento\Quote\Model\ShippingMethodManagement;
use GlsPoland\Shipping\Config\Config;

class ShippingMethodManagementPlugin
{
    /** @var Config */
    private Config $config;

    /**
     * Class constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * After Get Estimated Rates By Address
     *
     * @param ShippingMethodManagement $subject
     * @param array $result
     * @return array
     */
    public function afterEstimateByAddress(ShippingMethodManagement $subject, array $result): array
    {
        return $this->sortGlsPolandShippingMethods($result);
    }

    /**
     * After Get Estimated Rates By Extended Address
     *
     * @param ShippingMethodManagement $subject
     * @param array $result
     * @return array
     */
    public function afterEstimateByExtendedAddress(ShippingMethodManagement $subject, array $result): array
    {
        return $this->sortGlsPolandShippingMethods($result);
    }

    /**
     * After Get Estimated Rates By Address ID
     *
     * @param ShippingMethodManagement $subject
     * @param array $result
     * @return array
     */
    public function afterEstimateByAddressId(ShippingMethodManagement $subject, array $result): array
    {
        return $this->sortGlsPolandShippingMethods($result);
    }

    /**
     * Sort Gls Poland Shipping Methods
     *
     * @param array $methods
     * @return array
     */
    private function sortGlsPolandShippingMethods(array $methods): array
    {
        $glsPolandMethods = [];
        $otherMethods = [];

        foreach ($methods as $method) {
            if ($method->getCarrierCode() === 'glspoland') {
                $glsPolandMethods[] = $method;
            } else {
                $otherMethods[] = $method;
            }
        }

        usort($glsPolandMethods, function ($method1, $method2) {
            $position1 = $this->config->getShippingMethodPosition('glspoland_' . $method1->getMethodCode())
                ?? 1;
            $position2 = $this->config->getShippingMethodPosition('glspoland_' . $method2->getMethodCode())
                ?? 1;

            return $position1 <=> $position2;
        });

        return array_merge($glsPolandMethods, $otherMethods);
    }
}
