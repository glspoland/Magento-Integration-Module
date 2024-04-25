<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model\Carrier;

use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Helper\CarrierHelper;
use GlsPoland\Shipping\Helper\ConfigHelper;
use GlsPoland\Shipping\Model\ApiHandler;
use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Directory\Helper\Data;
use Magento\Directory\Model\CountryFactory;
use Magento\Directory\Model\CurrencyFactory;
use Magento\Directory\Model\RegionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Xml\Security;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory as RateErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory as RateMethodFactory;
use Magento\Sales\Api\Data\ShipmentExtensionFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrierOnline;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory as RateFactory;
use Magento\Shipping\Model\Shipment\Request as ShipmentRequest;
use Magento\Shipping\Model\Simplexml\ElementFactory;
use Magento\Shipping\Model\Tracking\Result as TrackingResult;
use Magento\Shipping\Model\Tracking\Result\ErrorFactory as TrackErrorFactory;
use Magento\Shipping\Model\Tracking\Result\StatusFactory as TrackStatusFactory;
use Magento\Shipping\Model\Tracking\ResultFactory as TrackFactory;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use GlsPoland\Shipping\Helper\Base64Helper;

class GlsShippingMethods extends AbstractCarrierOnline implements CarrierInterface
{
    public const PREPARING_BOX_ID_COLUMN_NAME = 'gls_poland_preparing_box_id';
    public const SHIPPING_CONFIRMATION_ID_COLUMN_NAME = 'gls_poland_shipping_confirmation_id';
    public const PICKUP_IDENT_COLUMN_NAME = 'gls_poland_pickup_ident';
    public const PICKUP_PARCELS_LABELS_COLUMN_NAME = 'gls_poland_pickup_parcels_labels';
    public const PICKUP_RECEIPT_COLUMN_NAME = 'gls_poland_pickup_receipt';
    public const PRICE_INCLUDES_TAX = 'tax/calculation/price_includes_tax';
    public const CARRIER_CODE = 'glspoland';
    public const TRACKING_URL_TEMPLATE = 'https://gls-group.eu/track/%s';

    /** @var Config */
    private Config $config;

    /** @var ConfigHelper */
    private ConfigHelper $configHelper;

    /** @var string */
    protected $_code = self::CARRIER_CODE;

    /** @var bool */
    protected $_isFixed = true;

    /** @var RateFactory */
    private RateFactory $rateResultFactory;

    /** @var RateMethodFactory */
    private RateMethodFactory $rateMethodFactory;

    /** @var CarrierHelper */
    private CarrierHelper $carrierHelper;

    /** @var ApiHandler */
    private ApiHandler $apiHandler;

    /** @var ScopeConfigInterface */
    private ScopeConfigInterface $scopeConfig;

    /** @var ShipmentExtensionFactory */
    protected ShipmentExtensionFactory $shipmentExtensionFactory;

    /** @var Base64Helper */
    protected Base64Helper $base64Helper;

    /**
     * Constructor method.
     *
     * @param CarrierHelper $carrierHelper
     * @param Config $config
     * @param ConfigHelper $configHelper
     * @param ApiHandler $apiHandler
     * @param ScopeConfigInterface $scopeConfig
     * @param RateErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param Security $xmlSecurity
     * @param ElementFactory $xmlElFactory
     * @param RateFactory $rateFactory
     * @param RateFactory $rateResultFactory
     * @param RateMethodFactory $rateMethodFactory
     * @param TrackFactory $trackFactory
     * @param TrackErrorFactory $trackErrorFactory
     * @param TrackStatusFactory $trackStatusFactory
     * @param RegionFactory $regionFactory
     * @param CountryFactory $countryFactory
     * @param CurrencyFactory $currencyFactory
     * @param Data $directoryData
     * @param StockRegistryInterface $stockRegistry
     * @param ShipmentExtensionFactory $shipmentExtensionFactory
     * @param Base64Helper $base64Helper
     * @param array $data
     */
    public function __construct(
        CarrierHelper $carrierHelper,
        Config $config,
        ConfigHelper $configHelper,
        ApiHandler $apiHandler,
        ScopeConfigInterface $scopeConfig,
        RateErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        Security $xmlSecurity,
        ElementFactory $xmlElFactory,
        RateFactory $rateFactory,
        RateFactory $rateResultFactory,
        RateMethodFactory $rateMethodFactory,
        TrackFactory $trackFactory,
        TrackErrorFactory $trackErrorFactory,
        TrackStatusFactory $trackStatusFactory,
        RegionFactory $regionFactory,
        CountryFactory $countryFactory,
        CurrencyFactory $currencyFactory,
        Data $directoryData,
        StockRegistryInterface $stockRegistry,
        ShipmentExtensionFactory $shipmentExtensionFactory,
        Base64Helper $base64Helper,
        array $data = [],
    ) {
        parent::__construct(
            $scopeConfig,
            $rateErrorFactory,
            $logger,
            $xmlSecurity,
            $xmlElFactory,
            $rateFactory,
            $rateMethodFactory,
            $trackFactory,
            $trackErrorFactory,
            $trackStatusFactory,
            $regionFactory,
            $countryFactory,
            $currencyFactory,
            $directoryData,
            $stockRegistry,
            $data
        );

        $this->carrierHelper = $carrierHelper;
        $this->config = $config;
        $this->configHelper = $configHelper;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->apiHandler = $apiHandler;
        $this->scopeConfig = $scopeConfig;
        $this->shipmentExtensionFactory = $shipmentExtensionFactory;
        $this->base64Helper = $base64Helper;
    }

    /**
     * Collect rates
     *
     * @param RateRequest $request
     * @return Result|bool
     */
    public function collectRates(RateRequest $request): Result|bool
    {
        if (!$this->config->getModuleEnable()) {
            return false;
        }

        $result = $this->rateResultFactory->create();

        foreach ($this->getShippingMethods($request) as $shippingMethod) {
            $method = $this->rateMethodFactory->create();
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($shippingMethod['title']);
            $method->setMethod($shippingMethod['code']);
            $method->setMethodTitle($shippingMethod['name']);
            $method->setPrice($shippingMethod['price']);
            $method->setCost($shippingMethod['price']);
            $result->append($method);
        }

        return $result;
    }

    /**
     * Get Carrier Code
     *
     * @return string
     */
    public function getCarrierCode(): string
    {
        return $this->_code;
    }

    /**
     * Get allowed methods.
     *
     * @return array
     */
    public function getAllowedMethods(): array
    {
        if (!$this->config->getModuleEnable()) {
            return [];
        }

        $shippingMethods = [];

        foreach (ShippingMethods::METHODS as $shippingCode => $shippingMethod) {
            if (!$this->config->getShippingMethodActive($shippingCode)) {
                continue;
            }

            $shippingMethods[$shippingMethod['code']] = $this->config->getShippingMethodName(
                $shippingCode
            );
        }

        return $shippingMethods;
    }

    /**
     * Processing additional validation to check if carrier applicable.
     *
     * @param DataObject $request
     * @return bool|DataObject|AbstractCarrierOnline
     */
    public function processAdditionalValidation(DataObject $request): bool|DataObject|AbstractCarrierOnline
    {
        return $this;
    }

    /**
     * Get shipping methods.
     *
     * @param RateRequest $request
     * @return array
     */
    private function getShippingMethods(RateRequest $request): array
    {
        $destCountryId = $request->getDestCountryId();
        $destPostcode = $request->getDestPostcode();
        $quoteValue = $this->configHelper->toFloat($this->getQuoteTotal($request));
        $shippingMethods = [];
        $serviceBOOL = null;

        if ($destPostcode !== null) {
            $serviceBOOL = $this->apiHandler->getServicesGuaranteed($destPostcode);
        }

        if (!$this->config->getModuleEnable()) {
            return $shippingMethods;
        }

        foreach (ShippingMethods::METHODS as $shippingCode => $shippingMethod) {
            if (!$this->config->getShippingMethodActive($shippingCode)) {
                continue;
            }

            if (!$this->carrierHelper->isCountryAllowed($destCountryId, $shippingCode)) {
                continue;
            }

            if ($shippingMethod['code'] === 'gls_parcel_shop'
                && !$this->carrierHelper->isCountryAllowedSDS($destCountryId)
            ) {
                continue;
            }

            if ($destPostcode !== null && $serviceBOOL !== null) {
                switch ($shippingMethod['code']) {
                    case 'gls_courier_10':
                        if (!$serviceBOOL->getS10()) {
                            continue 2;
                        }
                        break;
                    case 'gls_courier_12':
                        if (!$serviceBOOL->getS12()) {
                            continue 2;
                        }
                        break;
                    case 'gls_courier_sat':
                        if (!$serviceBOOL->getSat()) {
                            continue 2;
                        }
                        break;
                    case 'gls_courier_sat_10':
                        if (!$serviceBOOL->getSat() || !$serviceBOOL->getS10()) {
                            continue 2;
                        }
                        break;
                    case 'gls_courier_sat_12':
                        if (!$serviceBOOL->getSat() || !$serviceBOOL->getS12()) {
                            continue 2;
                        }
                        break;
                }
            }

            $freeShippingEnable = $this->config->getFreeShippingEnable($shippingCode);

            $freeShippingSubtotal = $this->configHelper->toFloat(
                $this->config->getFreeShippingSubtotal($shippingCode)
            );

            $shippingPrice = $this->configHelper->toFloat(
                $this->config->getShippingPrice($shippingCode)
            );

            if ($freeShippingEnable && $quoteValue >= $freeShippingSubtotal) {
                $shippingPrice = 0.0;
            }

            $shippingMethodName = $this->config->getShippingMethodName($shippingCode);
            $shippingMethodTitle = $this->config->getShippingMethodTitle($shippingCode);
            $shippingMethodPosition = (int)$this->config->getShippingMethodPosition($shippingCode) ?: 1;

            if ($shippingMethodName !== null) {
                $shippingMethods[] = [
                    'code' => $shippingMethod['code'],
                    'name' => $shippingMethodName,
                    'title' => $shippingMethodTitle,
                    'price' => $shippingPrice,
                    'position' => $shippingMethodPosition
                ];
            }
        }

        $sort = array_column($shippingMethods, 'position');
        array_multisort($sort, SORT_ASC, SORT_NUMERIC, $shippingMethods);

        return $shippingMethods;
    }

    /**
     * Get quote total.
     *
     * @param RateRequest $request
     * @return float
     */
    protected function getQuoteTotal(RateRequest $request): float
    {
        $items = $request->getAllItems();

        if (!$items) {
            return 0.0;
        }

        $totalValue = 0.0;
        $taxIncluded = $this->scopeConfig->getValue(self::PRICE_INCLUDES_TAX, ScopeInterface::SCOPE_STORE);

        foreach ($items as $item) {
            if ($item->getParentItem() || $item->getProduct()->isVirtual()) {
                continue;
            }

            $totalValue += $taxIncluded
                ? $item->getRowTotalInclTax() - $item->getDiscountAmount()
                : $item->getRowTotal() - $item->getDiscountAmount();
        }

        return $totalValue;
    }

    /**
     * Do request to shipment
     *
     * @param ShipmentRequest $request
     * @return DataObject
     * @throws LocalizedException
     */
    public function requestToShipment($request): DataObject
    {
        $packages = $request->getPackages();

        if (!is_array($packages) || !$packages) {
            throw new LocalizedException(__('No packages for request'));
        }

        if ($request->getStoreId() !== null) {
            $this->setStore($request->getStoreId());
        }

        $result = $this->_doShipmentRequest($request);
        $response = new DataObject();

        if ($result->hasErrorMsg()) {
            return $response->setErrorMsg($result->getErrorMsg());
        }

        $response->setPreparingBoxId($result->getPreparingBoxId() ?: null);
        $response->setPreparingBoxLabels($result->getPreparingBoxLabels() ?: null);
        $response->setPreparingBoxIdent($result->getPreparingBoxIdent() ?: null);
        $response->setPreparingBoxCustomsDec($result->getPreparingBoxCustomsDec() ?: null);
        $response->setShippingLabelFormat($result->getShippingLabelFormat() ?: null);

        return $response;
    }

    /**
     * Do shipment request to carrier web service
     *
     * @param DataObject $request
     * @return DataObject
     * @throws \Exception
     */
    protected function _doShipmentRequest(DataObject $request): DataObject
    {
        $orderShipment = $request->getOrderShipment();
        $result = new DataObject();

        if ($orderShipment) {
            $response = $this->apiHandler->createPreparingBox($request);

            if ($response->hasData('id') && $response->getData('id') !== null) {
                $preparingBoxId = $response->getData('id');
            } else {
                $errors[] = __('Error on add Preparing box to GLS.');

                if ($response->hasData('ErrorString')) {
                    $errors[] = __((string)$response->getData('ErrorString'));
                }

                if ($response->hasData('ErrorCode')) {
                    $errors[] = __((string)$response->getData('ErrorCode'));
                }

                $result->setErrorMsg(implode(' ', $errors));

                return $result;
            }

            /** @var stdClass $preparingBoxConsignDocs */
            $preparingBoxConsignDocs = $this->apiHandler->getPreparingBoxConsignDocs(
                (string)$preparingBoxId
            );

            if (empty($preparingBoxConsignDocs->labels)) {
                $result->setErrorMsg(__('Error on add Preparing box to GLS, result has no Labels.'));

                return $result;
            }

            /** @var string $preparingBoxConsignCustomsDec */
            $preparingBoxConsignCustomsDec = $this->apiHandler->getPreparingBoxConsignCustomsDec(
                (string)$preparingBoxId
            );

            $result->setPreparingBoxId($preparingBoxId);
            $result->setPreparingBoxLabels($this->base64Helper->decode($preparingBoxConsignDocs->labels));
            $result->setShippingLabelFormat($this->config->getShippingLabelType());

            if (!empty($preparingBoxConsignDocs->ident)) {
                $result->setPreparingBoxIdent($this->base64Helper->decode($preparingBoxConsignDocs->ident));
            }

            if (!empty($preparingBoxConsignCustomsDec)) {
                $result->setPreparingBoxCustomsDec($this->base64Helper->decode($preparingBoxConsignCustomsDec));
            }

        } else {
            $result->setErrorMsg(__('Order object is not available in the request.'));
        }

        return $result;
    }

    /**
     * Get tracking info
     *
     * @param string $shipmentNumber
     * @return TrackingResult
     */
    public function getTracking(string $shipmentNumber): TrackingResult
    {
        $result = $this->_trackFactory->create();

        $statusData = [
            'tracking' => $shipmentNumber,
            'carrier_title' => $this->config->getCarrierTitle(),
            'url' => sprintf(self::TRACKING_URL_TEMPLATE, $shipmentNumber),
        ];

        $status = $this->_trackStatusFactory->create(['data' => $statusData]);
        $result->append($status);

        return $result;
    }
}
