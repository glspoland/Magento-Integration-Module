<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Service\Soap;

use GlsPoland\Shipping\Config\Config;
use Magento\Framework\Webapi\Soap\ClientFactory;
use SoapClient as SoapMagentoClient;

class SoapClient
{
    /** @var SoapMagentoClient */
    private SoapMagentoClient $soapClient;

    /** @var Config */
    private Config $config;

    /** @var ClientFactory */
    private ClientFactory $soapClientFactory;

    /**
     * SoapClient constructor.
     *
     * @param Config $config
     * @param ClientFactory $soapClientFactory
     */
    public function __construct(Config $config, ClientFactory $soapClientFactory)
    {
        $this->config = $config;
        $this->soapClientFactory = $soapClientFactory;
        $this->configureClient();
    }

    /**
     * Get soap client.
     *
     * @return SoapMagentoClient
     */
    public function getSoapClient(): SoapMagentoClient
    {
        return $this->soapClient;
    }

    /**
     * Set soap client.
     *
     * @param SoapMagentoClient $soapClient
     * @return void
     */
    public function setSoapClient(SoapMagentoClient $soapClient): void
    {
        $this->soapClient = $soapClient;
    }

    /**
     * Configure Magento SOAP client.
     *
     * @param string|null $wsdl
     * @return SoapMagentoClient
     */
    public function configureClient(string $wsdl = null): SoapMagentoClient
    {
        $options = ['trace' => 1];
        $soapClient = $this->soapClientFactory->create(
            $wsdl ?? $this->config->getWsdl(),
            $options
        );
        $this->setSoapClient($soapClient);

        return $soapClient;
    }
}
