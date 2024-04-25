<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Block\Adminhtml\Shipping;

use Magento\Backend\Block\Widget\Button;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use GlsPoland\Shipping\Model\ApiHandler;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\ShipmentInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Sales\Api\ShipmentRepositoryInterface;

class GlsShipping extends Template
{
    private const PREPARING_BOX_ID_COLUMN_NAME = 'gls_poland_preparing_box_id';
    private const PREPARING_BOX_IDENT_COLUMN_NAME = 'gls_poland_preparing_box_ident';
    private const PREPARING_BOX_CUSTOMS_DEC_COLUMN_NAME = 'gls_poland_preparing_box_customs_dec';
    private const SHIPPING_CONFIRMATION_ID_COLUMN_NAME = 'gls_poland_shipping_confirmation_id';
    private const PICKUP_IDENT_COLUMN_NAME = 'gls_poland_pickup_ident';
    private const PICKUP_PARCELS_LABELS_COLUMN_NAME = 'gls_poland_pickup_parcels_labels';
    private const PICKUP_RECEIPT_COLUMN_NAME = 'gls_poland_pickup_receipt';
    private const PICKUP_CONSIGN_PODS_COLUMN_NAME = 'gls_poland_pickup_consign_pods';
    private const PICKUP_CONSIGN_CUSTOMS_DEC_COLUMN_NAME = 'gls_poland_pickup_consign_customs_dec';

    /** @var ShipmentRepositoryInterface */
    protected ShipmentRepositoryInterface $shipmentRepository;

    /** @var RequestInterface */
    protected RequestInterface $request;

    /** @var ApiHandler */
    protected ApiHandler $apiHandler;

    /**
     * Class constructor.
     *
     * @param ShipmentRepositoryInterface $shipmentRepository
     * @param RequestInterface $request
     * @param ApiHandler $apiHandler
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        ShipmentRepositoryInterface $shipmentRepository,
        RequestInterface $request,
        ApiHandler $apiHandler,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->shipmentRepository = $shipmentRepository;
        $this->request = $request;
        $this->apiHandler = $apiHandler;
    }

    /**
     * Get Gls Preparing Box id
     *
     * @return string|null
     */
    public function getPreparingBoxId(): ?string
    {
        return $this->getShipment()?->getData(self::PREPARING_BOX_ID_COLUMN_NAME);
    }

    /**
     * Has Gls Preparing Box id
     *
     * @return bool
     */
    public function hasPreparingBoxId(): bool
    {
        return $this->getPreparingBoxId() !== null;
    }

    /**
     * Get Gls Preparing Box IDENT
     *
     * @return string|null
     */
    public function getPreparingBoxIdent(): ?string
    {
        return $this->getShipment()?->getData(self::PREPARING_BOX_IDENT_COLUMN_NAME);
    }

    /**
     * Has Gls Preparing Box IDENT
     *
     * @return bool
     */
    public function hasPreparingBoxIdent(): bool
    {
        return $this->getPreparingBoxIdent() !== null;
    }

    /**
     * Get Gls Preparing Box Customs Dec
     *
     * @return string|null
     */
    public function getPreparingBoxCustomsDec(): ?string
    {
        return $this->getShipment()?->getData(self::PREPARING_BOX_CUSTOMS_DEC_COLUMN_NAME);
    }

    /**
     * Has Gls Preparing Box Customs Dec
     *
     * @return bool
     */
    public function hasPreparingBoxCustomsDec(): bool
    {
        return $this->getShipment()?->getData(self::PREPARING_BOX_CUSTOMS_DEC_COLUMN_NAME) !== null;
    }

    /**
     * Get Gls Shipping Confirmation id
     *
     * @return string|null
     */
    public function getShippingConfirmationId(): ?string
    {
        return $this->getShipment()?->getData(self::SHIPPING_CONFIRMATION_ID_COLUMN_NAME);
    }

    /**
     * Has Gls Shipping Confirmation id
     *
     * @return bool
     */
    public function hasShippingConfirmationId(): bool
    {
        return $this->getShippingConfirmationId() !== null;
    }

    /**
     * Get Gls Shipping Pickup Parcels Labels
     *
     * @return string|null
     */
    public function getPickupParcelsLabels(): ?string
    {
        return $this->getShipment()?->getData(self::PICKUP_PARCELS_LABELS_COLUMN_NAME);
    }

    /**
     * Has Gls Shipping Pickup Parcels Labels
     *
     * @return bool
     */
    public function hasPickupParcelsLabels(): bool
    {
        return $this->getPickupParcelsLabels() !== null;
    }

    /**
     * Get Gls Shipping Pickup Ident Label
     *
     * @return string|null
     */
    public function getPickupIdent(): ?string
    {
        return $this->getShipment()?->getData(self::PICKUP_IDENT_COLUMN_NAME);
    }

    /**
     * Has Gls Shipping Pickup Ident Label
     *
     * @return bool
     */
    public function hasPickupIdent(): bool
    {
        return $this->getPickupIdent() !== null;
    }

    /**
     * Get Gls Shipping Pickup Receipt Label
     *
     * @return string|null
     */
    public function getPickupReceipt(): ?string
    {
        return $this->getShipment()?->getData(self::PICKUP_RECEIPT_COLUMN_NAME);
    }

    /**
     * Has Gls Shipping Pickup Receipt Label
     *
     * @return bool
     */
    public function hasPickupReceipt(): bool
    {
        return $this->getPickupReceipt() !== null;
    }

    /**
     * Get Gls Shipping Pickup Consign PODs
     *
     * @return string|null
     */
    public function getPickupConsignPods(): ?string
    {
        return $this->getShipment()?->getData(self::PICKUP_CONSIGN_PODS_COLUMN_NAME);
    }

    /**
     * Has Gls Shipping Pickup Consign PODs Label
     *
     * @return bool
     */
    public function hasPickupConsignPods(): bool
    {
        return $this->getPickupConsignPods() !== null;
    }

    /**
     * Get Gls Shipping Pickup Consign PODs
     *
     * @return string|null
     */
    public function getPickupConsignCustomsDec(): ?string
    {
        return $this->getShipment()?->getData(self::PICKUP_CONSIGN_CUSTOMS_DEC_COLUMN_NAME);
    }

    /**
     * Has Gls Shipping Pickup Consign PODs Label
     *
     * @return bool
     */
    public function hasPickupConsignCustomsDec(): bool
    {
        return $this->getPickupConsignCustomsDec() !== null;
    }

    /**
     * Get Print Preparing Box Ident button html
     *
     * @return string|null
     */
    public function getPrintPreparingBoxIdentButton(): ?string
    {
        try {
            if ($this->hasPreparingBoxIdent()) {
                $url = $this->getUrl(
                    'gls_poland/shipment/printLabel',
                    [
                        'shipment_id' => $this->getShipmentId(),
                        'file_name' => 'Preparing-Box-IDENT',
                        'column_name' => self::PREPARING_BOX_IDENT_COLUMN_NAME
                    ]
                );

                return $this->getLayout()->createBlock(
                    Button::class
                )->setData(
                    [
                        'label' => __('Preparing Box IDENT'),
                        'onclick' => 'setLocation(\'' . $url . '\')'
                    ]
                )->toHtml();
            }

            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Get Print Preparing Box Customs Dec button html
     *
     * @return string|null
     */
    public function getPrintPreparingBoxCustomsDecButton(): ?string
    {
        try {
            if ($this->hasPreparingBoxCustomsDec()) {
                $url = $this->getUrl(
                    'gls_poland/shipment/printLabel',
                    [
                        'shipment_id' => $this->getShipmentId(),
                        'file_name' => 'Preparing-Box-Customs-Dec',
                        'column_name' => self::PREPARING_BOX_CUSTOMS_DEC_COLUMN_NAME
                    ]
                );

                return $this->getLayout()->createBlock(
                    Button::class
                )->setData(
                    [
                        'label' => __('Preparing Box Customs Dec'),
                        'onclick' => 'setLocation(\'' . $url . '\')'
                    ]
                )->toHtml();
            }

            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Get Create Pickup button
     *
     * @return string|null
     */
    public function getCreatePickupButton(): ?string
    {
        try {
            if (!$this->hasShippingConfirmationId()) {
                $url = $this->getUrl(
                    'gls_poland/shipment/createpickup',
                    [
                        'shipment_id' => $this->getShipmentId()
                    ]
                );

                return $this->getLayout()->createBlock(
                    Button::class
                )->setData(
                    [
                        'label' => __('Create Pickup'),
                        'onclick' => 'setLocation(\'' . $url . '\')'
                    ]
                )->toHtml();
            }

            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Get Print Pickup Ident Label button html
     *
     * @return string|null
     */
    public function getPrintPickupIdentButton(): ?string
    {
        try {
            if ($this->hasPickupIdent()) {
                $url = $this->getUrl(
                    'gls_poland/shipment/printLabel',
                    [
                        'shipment_id' => $this->getShipmentId(),
                        'file_name' => 'Pickup-IDENT',
                        'column_name' => self::PICKUP_IDENT_COLUMN_NAME
                    ]
                );

                return $this->getLayout()->createBlock(
                    Button::class
                )->setData(
                    [
                        'label' => __('Pickup IDENT'),
                        'onclick' => 'setLocation(\'' . $url . '\')'
                    ]
                )->toHtml();
            }

            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Get Print Pickup Parcels Labels button html
     *
     * @return string|null
     */
    public function getPrintPickupParcelsLabelsButton(): ?string
    {
        try {
            if ($this->hasPickupParcelsLabels()) {
                $url = $this->getUrl(
                    'gls_poland/shipment/printLabel',
                    [
                        'shipment_id' => $this->getShipmentId(),
                        'file_name' => 'Pickup-Parcels-Labels',
                        'column_name' => self::PICKUP_PARCELS_LABELS_COLUMN_NAME
                    ]
                );

                return $this->getLayout()->createBlock(
                    Button::class
                )->setData(
                    [
                        'label' => __('Pickup Parcels Labels'),
                        'onclick' => 'setLocation(\'' . $url . '\')'
                    ]
                )->toHtml();
            }

            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Get Print Pickup Receipt Label button html
     *
     * @return string|null
     */
    public function getPrintPickupReceiptButton(): ?string
    {
        try {
            if ($this->hasPickupReceipt()) {
                $url = $this->getUrl(
                    'gls_poland/shipment/printLabel',
                    [
                        'shipment_id' => $this->getShipmentId(),
                        'file_name' => 'Pickup-Receipt',
                        'column_name' => self::PICKUP_RECEIPT_COLUMN_NAME
                    ]
                );

                return $this->getLayout()->createBlock(
                    Button::class
                )->setData(
                    [
                        'label' => __('Pickup Receipt'),
                        'onclick' => 'setLocation(\'' . $url . '\')'
                    ]
                )->toHtml();
            }

            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Get Print Pickup Receipt Label button html
     *
     * @return string|null
     */
    public function getPrintPickupConsignPodsButton(): ?string
    {
        try {
            if ($this->hasPickupConsignPods()) {
                $url = $this->getUrl(
                    'gls_poland/shipment/printLabel',
                    [
                        'shipment_id' => $this->getShipmentId(),
                        'file_name' => 'Pickup-Consign-PODs',
                        'column_name' => self::PICKUP_CONSIGN_PODS_COLUMN_NAME
                    ]
                );

                return $this->getLayout()->createBlock(
                    Button::class
                )->setData(
                    [
                        'label' => __('Pickup Consign PODs'),
                        'onclick' => 'setLocation(\'' . $url . '\')'
                    ]
                )->toHtml();
            }

            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Get Print Pickup Consign Customs Dec Label button html
     *
     * @return string|null
     */
    public function getPrintPickupConsignCustomsDecButton(): ?string
    {
        try {
            if ($this->hasPickupConsignCustomsDec()) {
                $url = $this->getUrl(
                    'gls_poland/shipment/printLabel',
                    [
                        'shipment_id' => $this->getShipmentId(),
                        'file_name' => 'Pickup-Consign-Customs-Dec',
                        'column_name' => self::PICKUP_CONSIGN_CUSTOMS_DEC_COLUMN_NAME
                    ]
                );

                return $this->getLayout()->createBlock(
                    Button::class
                )->setData(
                    [
                        'label' => __('Pickup Consign Customs Dec'),
                        'onclick' => 'setLocation(\'' . $url . '\')'
                    ]
                )->toHtml();
            }

            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Get Create Pickup button html
     *
     * @return string
     */
    public function getCreatePickupButtonHtml(): string
    {
        return $this->getCreatePickupButton() ?? '';
    }

    /**
     * Get Preparing Box Buttons html
     *
     * @return string
     */
    public function getPrintPreparingBoxButtonsHtml(): string
    {
        $html = '';

        if ($this->hasPreparingBoxIdent()) {
            $html .= $this->getPrintPreparingBoxIdentButton();
        }

        if ($this->hasPreparingBoxCustomsDec()) {
            $html .= $this->getPrintPreparingBoxCustomsDecButton();
        }

        return $html;
    }

    /**
     * Get Pickup Buttons html
     *
     * @return string
     */
    public function getPrintPickupButtonsHtml(): string
    {
        $html = '';

        if ($this->hasPickupIdent()) {
            $html .= $this->getPrintPickupIdentButton();
        }

        if ($this->hasPickupParcelsLabels()) {
            $html .= $this->getPrintPickupParcelsLabelsButton();
        }

        if ($this->hasPickupReceipt()) {
            $html .= $this->getPrintPickupReceiptButton();
        }

        if ($this->hasPickupConsignCustomsDec()) {
            $html .= $this->getPrintPickupConsignCustomsDecButton();
        }

        if ($this->hasPickupConsignPods()) {
            $html .= $this->getPrintPickupConsignPodsButton();
        }

        return $html;
    }

    /**
     * Get Shipment
     *
     * @return ShipmentInterface|null
     */
    private function getShipment(): ?ShipmentInterface
    {
        $shipmentId = $this->request->getParam('shipment_id');

        if ($shipmentId !== null) {
            return $this->shipmentRepository->get($shipmentId);
        }

        return null;
    }

    /**
     * Get Shipment id
     *
     * @return string|null
     */
    public function getShipmentId(): ?string
    {
        return $this->getShipment()?->getEntityId();
    }
}
