<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\ApiConnection;

use GlsPoland\Shipping\Service\Soap\SoapSession;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use GlsPoland\Shipping\Config\Config;

class Check extends Action
{
    /** @var JsonFactory */
    protected JsonFactory $resultJsonFactory;

    /** @var Config */
    protected Config $config;

    /** @var SoapSession */
    protected SoapSession $soapSession;

    /**
     * Constructor.
     *
     * @param Config $config
     * @param SoapSession $soapSession
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Config $config,
        SoapSession $soapSession,
        Context $context,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);

        $this->config = $config;
        $this->soapSession = $soapSession;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute Json request.
     *
     * @return Json
     */
    public function execute(): Json
    {
        $result = $this->resultJsonFactory->create();
        $username = $this->getRequest()->getParam('username');
        $password = $this->getRequest()->getParam('password');
        $mode = $this->getRequest()->getParam('mode');

        if (empty($username) || empty($password)) {
            return $result->setData(
                [
                    'message' => __('Please fill in the required fields (GLS API Username and Password).')
                ]
            );
        }

        if ($this->checkApiConnection($username, $password, $mode)) {
            return $result->setData(
                [
                    'message' => __('API Connection Successful.')
                ]
            );
        }

        return $result->setData(
            [
                'message' => __('API Connection Failed.')
            ]
        );
    }

    /**
     * Check API connection.
     *
     * @param string $username
     * @param string $password
     * @param string $mode
     * @return bool
     */
    private function checkApiConnection(string $username, string $password, string $mode): bool
    {
        $wsdl = $mode === 'sandbox' ? Config::SANDBOX_WSDL : Config::PROD_WSDL;
        $processedPassword = $this->processPassword($password);

        if ($processedPassword === null) {
            return false;
        }

        $session = $this->soapSession->login($username, $processedPassword, $wsdl);
        $this->soapSession->logout();

        if (is_string($session)) {
            return true;
        }

        return false;
    }

    /**
     * Use password from param or config.
     *
     * @param string $password
     * @return string|null
     */
    private function processPassword(string $password): ?string
    {
        if (!empty($password) && !preg_match('/^\*+$/', $password)) {
            return $password;
        }

        return $this->config->getPassword();
    }
}
