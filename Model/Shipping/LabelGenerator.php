<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model\Shipping;

use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\Order\Shipment\TrackFactory;
use Magento\Shipping\Model\CarrierFactory;
use Magento\Shipping\Model\Shipping\LabelGenerator as BaseLabelGenerator;
use Magento\Shipping\Model\Shipping\LabelsFactory;
use Netresearch\ShippingCore\Api\LabelStatus\LabelStatusManagementInterface;
use Zend_Pdf_Exception;

class LabelGenerator extends BaseLabelGenerator
{
    /** @var LabelStatusManagementInterface */
    private LabelStatusManagementInterface $labelStatusManagement;

    /**
     * Class Constructor
     *
     * @param LabelStatusManagementInterface $labelStatusManagement
     * @param CarrierFactory $carrierFactory
     * @param LabelsFactory $labelFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param TrackFactory $trackFactory
     * @param Filesystem $filesystem
     */
    public function __construct(
        LabelStatusManagementInterface $labelStatusManagement,
        CarrierFactory $carrierFactory,
        LabelsFactory $labelFactory,
        ScopeConfigInterface $scopeConfig,
        TrackFactory $trackFactory,
        Filesystem $filesystem
    ) {
        parent::__construct(
            $carrierFactory,
            $labelFactory,
            $scopeConfig,
            $trackFactory,
            $filesystem
        );

        $this->labelStatusManagement = $labelStatusManagement;
    }

    /**
     * Create Label
     *
     * @param Shipment $shipment
     * @param RequestInterface $request
     * @return void
     * @throws LocalizedException
     * @throws Zend_Pdf_Exception
     */
    public function create(Shipment $shipment, RequestInterface $request): void
    {
        $order = $shipment->getOrder();
        $shippingMethodCode = $order->getShippingMethod();

        if (!isset(ShippingMethods::METHODS[$shippingMethodCode])) {
            parent::create($shipment, $request);
        }

        $shippingMethod = $order->getShippingMethod(true);
        $carrierCode = $shippingMethod->getCarrierCode();
        $carrier = $this->carrierFactory->create($carrierCode);

        if (!$carrier->isShippingLabelsAvailable()) {
            throw new LocalizedException(__('Shipping labels is not available.'));
        }

        $shipment->setPackages($request->getParam('packages'));
        $response = $this->labelFactory->create()->requestToShipment($shipment);

        if ($response->hasErrorMsg()) {
            $this->labelStatusManagement->setLabelStatusFailed($order);
            throw new LocalizedException(__($response->getErrorMsg()));
        }

        if (!$response->hasPreparingBoxId()) {
            $this->labelStatusManagement->setLabelStatusFailed($order);
            throw new LocalizedException(__('Response Preparing Box Id is not exist.'));
        }

        if (!$response->hasPreparingBoxLabels()) {
            $this->labelStatusManagement->setLabelStatusFailed($order);
            throw new LocalizedException(__('Response Preparing Box Shipping Label Content is not exist.'));
        }

        $shipment->setGlsPolandPreparingBoxId($response->getPreparingBoxId());

        switch ($response->getShippingLabelFormat()) {
            case 'roll_160x100_datamax':
            case 'roll_160x100_zebra':
            case 'roll_160x100_zebra_300':
            case 'roll_160x100_zebra_epl':
                $shipment->setShippingLabel($response->getPreparingBoxLabels());
                break;
            default:
                $shipment->setShippingLabel($this->combineLabelsPdf([$response->getPreparingBoxLabels()])->render());
                break;
        }

        $shipment->setGlsPolandShippingLabelFormat($response->getShippingLabelFormat());

        if ($response->hasPreparingBoxIdent() && !empty($response->getPreparingBoxIdent())) {
            $shipment->setGlsPolandPreparingBoxIdent(
                $this->combineLabelsPdf([$response->getPreparingBoxIdent()])
                    ->render()
            );
        }

        if ($response->hasPreparingBoxCustomsDec() && !empty($response->getPreparingBoxCustomsDec())) {
            $shipment->setGlsPolandPreparingBoxCustomsDec(
                $this->combineLabelsPdf([$response->getPreparingBoxCustomsDec()])
                    ->render()
            );
        }

        $this->labelStatusManagement->setLabelStatusPartial($order);
    }
}
