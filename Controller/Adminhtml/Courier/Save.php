<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Courier;

use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Service\Soap\SoapRequest;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;

class Save extends Action
{
    public const ADMIN_RESOURCE = 'GlsPoland_Shipping::gls_courier';

    /** @var Config */
    protected Config $config;

    /** @var SoapRequest */
    protected SoapRequest $soapRequest;

    /**
     * Class constructor.
     *
     * @param Config $config
     * @param SoapRequest $soapRequest
     * @param Context $context
     */
    public function __construct(
        Config $config,
        SoapRequest $soapRequest,
        Context $context,
    ) {
        $this->config = $config;
        $this->soapRequest = $soapRequest;

        parent::__construct($context);
    }

    /**
     * Execute Page request.
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $glsCourierForm = $this->getRequest()->getParam('gls_courier_form');
        $parcelCount = isset($glsCourierForm['parcel_count']) ? (int)$glsCourierForm['parcel_count'] : null;
        $receiptDate = isset($glsCourierForm['receipt_date']) ? (string)$glsCourierForm['receipt_date'] : null;
        $useEmail = isset($glsCourierForm['use_email']) ? (bool)$glsCourierForm['use_email'] : null;

        if ($parcelCount === null || $receiptDate === null || $useEmail === null) {
            $this->messageManager->addErrorMessage(
                __('Error sending GLS Poland Courier order, please complete the required fields!')
            );

            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }

        $result = $this->soapRequest->addCourierOrder((int)$parcelCount, (string)$receiptDate, (bool)$useEmail);

        if ($result === true) {
            $this->messageManager->addSuccessMessage(__('GLS Poland Courier order has been sent'));

            return $this->resultRedirectFactory->create()->setPath('sales/order/index');
        }

        if ($result === false) {
            $this->messageManager->addErrorMessage(__('Error sending GLS Poland Courier order!'));

            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }

        if (is_string($result)) {
            $this->messageManager->addErrorMessage(__('Error sending GLS Poland Courier order!'));
            $this->messageManager->addErrorMessage(__('Result message: %1', $result));

            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }

        return $this->resultRedirectFactory->create()->setPath('sales/order/index');
    }

    /**
     * Check Permission.
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('GlsPoland_Shipping::gls_courier');
    }
}
