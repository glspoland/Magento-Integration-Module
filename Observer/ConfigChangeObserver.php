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
use Magento\Framework\App\Config\ReinitableConfigInterface;

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

    /** @var ReinitableConfigInterface */
    private ReinitableConfigInterface $reinitableConfig;

    /**
     * Constructor class
     *
     * @param Config $config
     * @param ApiHandler $apiHandler
     * @param ManagerInterface $messageManager
     * @param CacheInterface $cacheInterface
     * @param ReinitableConfigInterface $reinitableConfig
     */
    public function __construct(
        Config $config,
        ApiHandler $apiHandler,
        ManagerInterface $messageManager,
        CacheInterface $cacheInterface,
        ReinitableConfigInterface $reinitableConfig
    ) {
        $this->config = $config;
        $this->apiHandler = $apiHandler;
        $this->messageManager = $messageManager;
        $this->cacheInterface = $cacheInterface;
        $this->reinitableConfig = $reinitableConfig;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        error_log('[ConfigChangeObserver] Config saved — observer triggered.');
        $this->cacheInterface->clean(['config']);
        $this->reinitableConfig->reinit();
        error_log('[ConfigChangeObserver] Config cache cleaned and reinitialized.');

        if ($this->config->getModuleEnable()) {
            error_log('[ConfigChangeObserver] Module is enabled, running validateServices.');
            $this->validateServices();
        } else {
            error_log('[ConfigChangeObserver] Module is disabled, skipping validateServices.');
        }
    }

    /**
     * Validate services
     *
     * @return void
     */
    private function validateServices(): void
    {
        error_log('[ConfigChangeObserver] Calling getServicesAllowed...');
        $serviceBOOL = $this->apiHandler->getServicesAllowed();

        if ($serviceBOOL !== null) {
            error_log('[ConfigChangeObserver] getServicesAllowed returned a result.');
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
        } else {
            error_log('[ConfigChangeObserver] getServicesAllowed returned null — login likely failed.');
        }

        error_log('[ConfigChangeObserver] Calling getServicesMaxCOD...');
        $servicesMaxCOD = $this->apiHandler->getServicesMaxCOD();
        error_log(sprintf('[ConfigChangeObserver] getServicesMaxCOD returned: %s', $servicesMaxCOD !== null ? (string)$servicesMaxCOD : 'null'));

        if ($servicesMaxCOD !== null) {
            $this->config->setServicesMaxCOD($servicesMaxCOD);
            error_log('[ConfigChangeObserver] Max COD saved to config.');
        }

        $servicesCountriesSDS = $this->apiHandler->getServicesCountriesSDS();
        error_log(sprintf('[ConfigChangeObserver] getServicesCountriesSDS returned: %s', $servicesCountriesSDS !== null ? implode(',', $servicesCountriesSDS) : 'null'));

        if ($servicesCountriesSDS !== null) {
            $this->config->setServicesCountriesSDS($servicesCountriesSDS);
        }
    }
}
