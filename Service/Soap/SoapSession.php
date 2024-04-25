<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Service\Soap;

use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Model\Log;
use SoapFault;

class SoapSession
{
    /** @var Config */
    protected Config $config;

    /** @var Log */
    protected Log $log;

    /** @var SoapClient */
    protected SoapClient $soapClient;

    /** @var null|string */
    private ?string $soapSession = null;

    /**
     * Class constructor.
     *
     * @param SoapClient $soapClient
     * @param Config $config
     * @param Log $log
     */
    public function __construct(
        SoapClient $soapClient,
        Config $config,
        Log $log
    ) {
        $this->soapClient = $soapClient;
        $this->config = $config;
        $this->log = $log;
        $this->login();
    }

    /**
     * Class destructor.
     */
    public function __destruct()
    {
        $this->logout();
    }

    /**
     * Get soap session.
     *
     * @return string|null
     */
    public function getSoapSession(): ?string
    {
        return $this->soapSession;
    }

    /**
     * Set soap session.
     *
     * @param string $soapSession
     * @return void
     */
    public function setSoapSession(string $soapSession): void
    {
        $this->soapSession = $soapSession;
    }

    /**
     * Unset soap session.
     *
     * @return void
     */
    public function unsetSoapSession(): void
    {
        $this->soapSession = null;
    }

    /**
     * Login to GLS API.
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $wsdl
     * @return string|null
     */
    public function login(string $username = null, string $password = null, string $wsdl = null): ?string
    {
        try {
            $request = [
                'user_name'=> $username ?? $this->config->getUserName(),
                'user_password' => $password ?? $this->config->getPassword(),
                'integrator' => $this->config->getIntegratorId()
            ];

            $client = $wsdl ? $this->soapClient->configureClient($wsdl) : $this->soapClient->getSoapClient();
            $response = $client->__soapCall("adeLoginIntegrator", ['parameters' => $request]);

            if (isset($response->return->session) && is_string($response->return->session)) {
                $this->setSoapSession($response->return->session);

                return $response->return->session;
            }

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s]',
                        __METHOD__,
                    )
                );
            }
        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s',
                        __METHOD__,
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Logout from GLS API.
     *
     * @return bool
     */
    public function logout(): bool
    {
        try {
            $session = $this->getSoapSession();

            if ($session === null) {
                return false;
            }

            $request = ['session' => $session];
            $client = $this->soapClient->getSoapClient();

            $response = $client ->__soapCall("adeLogout", ['parameters' => $request]);

            if (isset($response->return->session)
                && is_string($response->return->session)
                && $response->return->session === $this->getSoapSession()
            ) {
                $this->unsetSoapSession();

                return true;
            }

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s]',
                        __METHOD__
                    )
                );
            }
        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s',
                        __METHOD__,
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return false;
    }
}
