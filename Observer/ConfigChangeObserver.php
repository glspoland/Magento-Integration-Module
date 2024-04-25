<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Model\ApiHandler;
use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\CacheInterface;

class ConfigChangeObserver implements ObserverInterface
{
    /** @var Config */
    private Config $config;

    /** @var ApiHandler */
    private ApiHandler $apiHandler;

    /** @var ManagerInterface */
    private ManagerInterface $messageManager;

    /** @var CacheInterface */
    protected CacheInterface $cacheInterface;

    /**
     * Constructor class
     *
     * @param Config $config
     * @param ApiHandler $apiHandler
     * @param ManagerInterface $messageManager
     * @param CacheInterface $cacheInterface
     */
    public function __construct(
        Config $config,
        ApiHandler $apiHandler,
        ManagerInterface $messageManager,
        CacheInterface $cacheInterface
    ) {
        $this->config = $config;
        $this->apiHandler = $apiHandler;
        $this->messageManager = $messageManager;
        $this->cacheInterface = $cacheInterface;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        if ($this->config->getModuleEnable()) {
            $this->validateServices();
        }
    }

    /**
     * Validate services
     *
     * @return void
     */
    private function validateServices(): void
    {
        $serviceBOOL = $this->apiHandler->getServicesAllowed();

        if ($serviceBOOL !== null) {
            $addErrorMessage = false;

            foreach (ShippingMethods::METHODS as $shippingCode => $shippingMethod) {
                if ($this->config->getShippingMethodActive($shippingCode)) {
                    if ($shippingMethod['code'] === 'gls_courier_10' && !$serviceBOOL->getS10()) {
                        $this->config->setShippingMethodActive('0', $shippingCode);
                        $addErrorMessage = true;
                    }

                    if ($shippingMethod['code'] === 'gls_courier_12' && !$serviceBOOL->getS12()) {
                        $this->config->setShippingMethodActive('0', $shippingCode);
                        $addErrorMessage = true;
                    }

                    if ($shippingMethod['code'] === 'gls_courier_sat' && !$serviceBOOL->getSat()) {
                        $this->config->setShippingMethodActive('0', $shippingCode);
                        $addErrorMessage = true;
                    }

                    if ($shippingMethod['code'] === 'gls_courier_sat_10'
                        && (!$serviceBOOL->getSat() || !$serviceBOOL->getS10())
                    ) {
                        $this->config->setShippingMethodActive('0', $shippingCode);
                        $addErrorMessage = true;
                    }

                    if ($shippingMethod['code'] === 'gls_courier_sat_12'
                        && (!$serviceBOOL->getSat() || !$serviceBOOL->getS12())
                    ) {
                        $this->config->setShippingMethodActive('0', $shippingCode);
                        $addErrorMessage = true;
                    }
                }

                if ($this->config->getShippingMethodCod($shippingCode) && !$serviceBOOL->getCod()) {
                    $this->config->setShippingMethodCod('0', $shippingCode);
                    $addErrorMessage = true;
                }
            }

            if ($addErrorMessage) {
                $this->messageManager->addErrorMessage(
                    __('The user does not have the appropriate permissions to execute the specified method.')
                );
                $this->cacheInterface->clean(['config']);
            }
        }

        $servicesMaxCOD = $this->apiHandler->getServicesMaxCOD();

        if ($servicesMaxCOD !== null) {
            $this->config->setServicesMaxCOD($servicesMaxCOD);
        }

        $servicesCountriesSDS = $this->apiHandler->getServicesCountriesSDS();

        if ($servicesCountriesSDS !== null) {
            $this->config->setServicesCountriesSDS($servicesCountriesSDS);
        }
    }
}
