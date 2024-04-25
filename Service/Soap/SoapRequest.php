<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Service\Soap;

use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Helper\DateHelper;
use GlsPoland\Shipping\Model\Consign;
use GlsPoland\Shipping\Model\ConsignFactory;
use GlsPoland\Shipping\Model\ConsignsIDsArray;
use GlsPoland\Shipping\Model\ConsignsIDsArrayFactory;
use GlsPoland\Shipping\Model\LabelsArray;
use GlsPoland\Shipping\Model\LabelsArrayFactory;
use GlsPoland\Shipping\Model\Log;
use GlsPoland\Shipping\Model\Pickup;
use GlsPoland\Shipping\Model\PickupFactory;
use GlsPoland\Shipping\Model\PickupsIDsArray;
use GlsPoland\Shipping\Model\PickupsIDsArrayFactory;
use GlsPoland\Shipping\Model\PodsArray;
use GlsPoland\Shipping\Model\PodsArrayFactory;
use GlsPoland\Shipping\Model\ServiceBOOL;
use GlsPoland\Shipping\Model\ServiceBOOLFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use SoapFault;
use stdClass;
use GlsPoland\Shipping\Model\ParcelShop;
use GlsPoland\Shipping\Model\ParcelShopFactory;

class SoapRequest
{
    /** @var SoapSession */
    private SoapSession $soapSession;

    /** @var SoapClient */
    private SoapClient $soapClient;

    /** @var Log */
    private Log $log;

    /** @var Config */
    private Config $config;

    /** @var DateHelper */
    private DateHelper $dateHelper;

    /** @var JsonSerializer */
    private JsonSerializer $jsonSerializer;

    /** @var ConsignFactory */
    protected ConsignFactory $consignFactory;

    /** @var ConsignsIDsArrayFactory */
    protected ConsignsIDsArrayFactory $consignsIDsArrayFactory;

    /** @var LabelsArrayFactory */
    protected LabelsArrayFactory $labelsArrayFactory;

    /** @var PickupsIDsArrayFactory */
    protected PickupsIDsArrayFactory $pickupsIDsArrayFactory;

    /** @var PickupFactory */
    protected PickupFactory $pickupFactory;

    /** @var PodsArrayFactory */
    protected PodsArrayFactory $podsArrayFactory;

    /** @var ServiceBOOLFactory */
    protected ServiceBOOLFactory $serviceBOOLFactory;

    /** @var ParcelShopFactory */
    protected ParcelShopFactory $parcelShopFactory;

    /**
     * SoapRequest constructor.
     *
     * @param SoapSession $soapSession
     * @param SoapClient $soapClient
     * @param Log $log
     * @param Config $config
     * @param DateHelper $dateHelper
     * @param JsonSerializer $jsonSerializer
     * @param ConsignFactory $consignFactory
     * @param ConsignsIDsArrayFactory $consignsIDsArrayFactory
     * @param LabelsArrayFactory $labelsArrayFactory
     * @param PickupsIDsArrayFactory $pickupsIDsArrayFactory
     * @param PickupFactory $pickupFactory
     * @param PodsArrayFactory $podsArrayFactory
     * @param ServiceBOOLFactory $serviceBOOLFactory
     * @param ParcelShopFactory $parcelShopFactory
     */
    public function __construct(
        SoapSession $soapSession,
        SoapClient $soapClient,
        Log $log,
        Config $config,
        DateHelper $dateHelper,
        JsonSerializer $jsonSerializer,
        ConsignFactory $consignFactory,
        ConsignsIDsArrayFactory $consignsIDsArrayFactory,
        LabelsArrayFactory $labelsArrayFactory,
        PickupsIDsArrayFactory $pickupsIDsArrayFactory,
        PickupFactory $pickupFactory,
        PodsArrayFactory $podsArrayFactory,
        ServiceBOOLFactory $serviceBOOLFactory,
        ParcelShopFactory $parcelShopFactory
    ) {
        $this->soapSession = $soapSession;
        $this->soapClient = $soapClient;
        $this->log = $log;
        $this->config = $config;
        $this->dateHelper = $dateHelper;
        $this->jsonSerializer = $jsonSerializer;
        $this->consignFactory = $consignFactory;
        $this->consignsIDsArrayFactory = $consignsIDsArrayFactory;
        $this->labelsArrayFactory = $labelsArrayFactory;
        $this->pickupsIDsArrayFactory = $pickupsIDsArrayFactory;
        $this->pickupFactory = $pickupFactory;
        $this->podsArrayFactory = $podsArrayFactory;
        $this->serviceBOOLFactory = $serviceBOOLFactory;
        $this->parcelShopFactory = $parcelShopFactory;
    }

    /**
     * Get PFC status.
     *
     * @return int|null
     */
    public function getPfc(): ?int
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePfc_GetStatus",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession()
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_string($response->return->status)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_string($response->return->status)
                            ? 'Unexpected API response: Result is not string'
                            : ''
                    )
                );
            }

            if (!is_string($response->return->status)) {
                return null;
            }

            return $response->return->status;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->soapClient->getSoapClient()->__getLastRequest(),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get availability status of the Sender Addresses service
     *
     * @return string|null
     */
    public function getSender(): ?string
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adeSendAddr_GetStatus",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession()
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_string($response->return->status)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_string($response->return->status)
                            ? 'Unexpected API response: Result is not string'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_string($response->return->status)) {
                return null;
            }

            return $response->return->status;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->soapClient->getSoapClient()->__getLastRequest(),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return $response->return->status;
    }

    /**
     * Insert Preparing Box
     *
     * @param Consign $consign
     * @return DataObject
     */
    public function insertPreparingBox(Consign $consign): DataObject
    {
        $result = new DataObject();

        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePreparingBox_Insert",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'consign_prep_data' => $consign
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_int((int)$response->return->id)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_int((int)$response->return->id)
                            ? 'Unexpected API response: Result is not int'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_int((int)$response->return->id)) {
                $result->setData('id', null);
                $result->setData('ErrorString', __('Unexpected API response: Result is not int.'));
            } else {
                $result->setData('id', (int)$response->return->id);
            }

            return $result;

        } catch (SoapFault $fault) {
            $result->setData('id', null);
            $result->setData('ErrorCode', $fault->faultcode);

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return $result;
    }

    /**
     * Get labels and IDENT service.
     *
     * @param int $id
     * @param string $mode
     * @return stdClass|null
     */
    public function getPreparingBoxConsignDocs(int $id, string $mode): ?stdClass
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePreparingBox_GetConsignDocs",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id,
                        'mode' => $mode
                    ]
                ]
            );

            $validResult = $this->validApiResult($response->return, 'stdClass', ['labels', 'ident']);

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $validResult !== true
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        $validResult !== true
                            ? 'Unexpected API response: ' . $validResult
                            : 'API response: Result is valid'
                    )
                );
            }

            if ($validResult !== true) {
                return null;
            }

            return $response->return;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get customs declaration for a shipment.
     *
     * @param int $id
     * @return string|null
     */
    public function getPreparingBoxConsignCustomsDec(int $id): ?string
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePreparingBox_GetConsignCustomsDec",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_string($response->return->file_pdf)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_string($response->return->file_pdf)
                            ? 'Unexpected API response: Result is not string'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_string($response->return->file_pdf)) {
                return null;
            }

            return (string)$response->return->file_pdf;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Remove the shipment from the preparation room
     *
     * @param int $id
     * @return int|null
     */
    public function getPreparingBoxDeleteConsign(int $id): ?int
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePreparingBox_DeleteConsign",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_int((int)$response->return->id)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_int((int)$response->return->id)
                            ? 'Unexpected API response: Result is not int'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_int((int)$response->return->id)) {
                return null;
            }

            return (int)$response->return->id;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Crate pickup
     *
     * @param ConsignsIDsArray $ids
     * @param string $desc
     * @return int|null
     */
    public function pickupCreate(ConsignsIDsArray $ids, string $desc): ?int
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePickup_Create",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'consigns_ids' => $ids,
                        'desc' => $desc
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_int((int)$response->return->id)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_int((int)$response->return->id)
                            ? 'Unexpected API response: Result is not int'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_int((int)$response->return->id)) {
                return null;
            }

            return (int)$response->return->id;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get pickup consigns IDs
     *
     * @param int $id
     * @return ConsignsIDsArray|null
     */
    public function pickupGetConsignIDs(int $id): ?ConsignsIDsArray
    {
        $items = null;
        $id_start = 0;

        do {
            $consignIDs = $this->_pickupGetConsignIDs($id, $id_start);

            if ($consignIDs !== null) {
                foreach ($consignIDs as $consignID) {
                    $items[] = $consignID;
                }

                $id_start = end($consignIDs);
            } else {
                break;
            }

        } while (count($consignIDs) === 100);

        $validResult = $this->validApiResult(['items' => $items], ConsignsIDsArray::class);

        if ($this->config->isDebugEnabled()) {
            $this->log->add(
                $validResult !== true
                    ? $this->log::LOG_TYPE_ERROR
                    : $this->log::LOG_TYPE_INFO,
                'GLS API',
                sprintf(
                    '[%s] %s %s %s',
                    __METHOD__,
                    $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                    $this->toString(['items' => $items]),
                    $validResult !== true
                        ? 'Unexpected API response: ' . $validResult
                        : 'API response: result is valid'
                )
            );
        }

        if ($validResult !== true) {
            return null;
        }

        return $this->consignsIDsArrayFactory->create(['items' => $items]);
    }

    /**
     * Get pickup consigns IDs API
     *
     * @param int $id
     * @param int $idStart
     * @return array|null
     */
    private function _pickupGetConsignIDs(int $id, int $idStart = 0): ?array
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePickup_GetConsignIDs",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id,
                        'id_start' => $idStart
                    ]
                ]
            );

            $items = null;

            if (isset($response->return->items)) {
                if (is_array($response->return->items) || is_object($response->return->items)) {
                    foreach ($response->return->items as $item) {
                        $items[] = $item;
                    }
                } elseif (is_int($response->return->items)) {
                    $items[] = $response->return->items;
                }
            }

            $validResult = $this->validApiResult(['items' => $items], ConsignsIDsArray::class);

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $validResult !== true
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        $validResult !== true
                            ? 'Unexpected API response: ' . $validResult
                            : 'API response: result is valid'
                    )
                );
            }

            if ($validResult !== true) {
                return null;
            }

            return $items;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get pickup consigns
     *
     * @param int $id
     * @return Consign|null
     */
    public function pickupGetConsign(int $id): ?Consign
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePickup_GetConsign",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id
                    ]
                ]
            );

            $validResult = $this->validApiResult($response->return, Consign::class);

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $validResult !== true
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        $validResult !== true
                            ? 'Unexpected API response: ' . $validResult
                            : 'API response: result is valid'
                    )
                );
            }

            if ($validResult !== true) {
                return null;
            }

            return $this->consignFactory->create((array)$response->return);

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get pickup consigns
     *
     * @param int $id
     * @param string $mode
     * @return string|null
     */
    public function pickupGetReceipt(int $id, string $mode): ?string
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePickup_GetReceipt",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id,
                        'mode' => $mode
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_string($response->return->receipt)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_string($response->return->receipt)
                            ? 'Unexpected API response: Result is not string'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_string($response->return->receipt)) {
                return null;
            }

            return (string)$response->return->receipt;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get pickup labels
     *
     * @param int $id
     * @param string $mode
     * @return string|null
     */
    public function pickupGetLabels(int $id, string $mode): ?string
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePickup_GetLabels",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id,
                        'mode' => $mode
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_string($response->return->labels)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_string($response->return->labels)
                            ? 'Unexpected API response: Result is not string'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_string($response->return->labels)) {
                return null;
            }

            return (string)$response->return->labels;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get pickup ident
     *
     * @param int $id
     * @return string|null
     */
    public function pickupGetIdent(int $id): ?string
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePickup_GetIdent",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_string($response->return->ident)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_string($response->return->ident)
                            ? 'Unexpected API response: Result is not string'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_string($response->return->ident)) {
                return null;
            }

            return (string)$response->return->ident;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get pickup consign customs dec
     *
     * @param int $id
     * @return string|null
     */
    public function pickupGetConsignCustomsDec(int $id): ?string
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePickup_GetConsignCustomsDec",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_string($response->return->file_pdf)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_string($response->return->file_pdf)
                            ? 'Unexpected API response: Result is not string'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_string($response->return->file_pdf)) {
                return null;
            }

            return (string)$response->return->file_pdf;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get pickup consign PODs
     *
     * @param int $id
     * @return PodsArray|null
     */
    public function pickupGetConsignPODs(int $id): ?PodsArray
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adePickup_GetConsignPODs",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id
                    ]
                ]
            );

            $validResult = $this->validApiResult(
                ['items' => $response->return->items],
                PodsArray::class
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $validResult !== true
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        $validResult !== true
                            ? 'Unexpected API response: ' . $validResult
                            : 'API response: result is valid'
                    )
                );
            }

            if ($validResult !== true) {
                return null;
            }

            $items = [];

            if (is_object($response->return->items) &&
                isset($response->return->items->number, $response->return->items->file_pdf)
            ) {
                $items[] = $response->return->items;
            } elseif (is_array($response->return->items)) {
                $items = $response->return->items;
            }

            return $this->podsArrayFactory->create(['items' => $items]);

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Add Courier Order
     *
     * @param int $parcelAmount
     * @param string $date
     * @param bool $emailNotification
     * @return bool|string
     */
    public function addCourierOrder(int $parcelAmount, string $date, bool $emailNotification = false): bool|string
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adeCourier_Order",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'parcelamount' => $parcelAmount,
                        'date' => $this->dateHelper->getDate($date, 'Y-m-d'),
                        'emailnotification' => $emailNotification
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_bool($response->return->value)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_bool($response->return->value)
                            ? 'Unexpected API response: Result is not bool'
                            : 'API response: Result is valid'
                    )
                );
            }

            if (!is_bool($response->return->value)) {
                return (string)__('Unexpected API response: Result is not bool');
            }

            return (bool)$response->return->value;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->soapClient->getSoapClient()->__getLastRequest(),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return sprintf('%s %s', $fault->faultcode, $fault->faultstring);
    }

    /**
     * Get Services Guaranteed
     *
     * @param string $zipcode
     * @return ServiceBOOL|null
     */
    public function getServicesGuaranteed(string $zipcode): ?ServiceBOOL
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adeServices_GetGuaranteed",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'zipcode' => $zipcode
                    ]
                ]
            );

            $validResult = $this->validApiResult($response->return->srv_bool, ServiceBOOL::class);

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $validResult !== true
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        $validResult !== true
                            ? 'Unexpected API response: ' . $validResult
                            : 'API response: result is valid'
                    )
                );
            }

            if ($validResult !== true) {
                return null;
            }

            return $this->serviceBOOLFactory->create(
                [
                    'cod' => $response->return->srv_bool->cod,
                    'cod_amount' => $response->return->srv_bool->cod_amount,
                    'exw' => $response->return->srv_bool->exw,
                    'rod' => $response->return->srv_bool->rod,
                    'pod' => $response->return->srv_bool->pod,
                    'exc' => $response->return->srv_bool->exc,
                    'ident' => $response->return->srv_bool->ident,
                    'daw' => $response->return->srv_bool->daw,
                    'ps' => $response->return->srv_bool->ps,
                    'pr' => $response->return->srv_bool->pr,
                    's10' => $response->return->srv_bool->s10,
                    's12' => $response->return->srv_bool->s12,
                    'sat' => $response->return->srv_bool->sat,
                    'ow' => $response->return->srv_bool->ow,
                    'srs' => $response->return->srv_bool->srs,
                    'sds' => $response->return->srv_bool->sds,
                    'cdx' => null,
                    'cdx_amount' => null,
                    'cdx_currency' => null,
                    'ado' => null,
                ]
            );

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->soapClient->getSoapClient()->__getLastRequest(),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get Service Max COD
     *
     * @return float|null
     */
    public function getServicesMaxCOD(): ?float
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adeServices_GetMaxCOD",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession()
                    ]
                ]
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    !is_float((float)$response->return->max_cod)
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        !is_float((float)$response->return->max_cod)
                            ? 'Unexpected API response: Result is not float'
                            : 'API response: result is valid'
                    )
                );
            }

            if (!is_float((float)$response->return->max_cod)) {
                return null;
            }

            return (float)$response->return->max_cod;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->soapClient->getSoapClient()->__getLastRequest(),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get Service Allowed
     *
     * @return ServiceBool|null
     */
    public function getServicesAllowed(): ?ServiceBool
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adeServices_GetAllowed",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession()
                    ]
                ]
            );

            $validResult = $this->validApiResult($response->return->srv_bool, ServiceBOOL ::class);

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $validResult !== true
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        $validResult !== true
                            ? 'Unexpected API response: ' . $validResult
                            : 'API response: result is valid'
                    )
                );
            }

            if ($validResult !== true) {
                return null;
            }

            return $this->serviceBOOLFactory->create(
                [
                    'cod' => $response->return->srv_bool->cod,
                    'cod_amount' => $response->return->srv_bool->cod_amount,
                    'exw' => $response->return->srv_bool->exw,
                    'rod' => $response->return->srv_bool->rod,
                    'pod' => $response->return->srv_bool->pod,
                    'exc' => $response->return->srv_bool->exc,
                    'ident' => $response->return->srv_bool->ident,
                    'daw' => $response->return->srv_bool->daw,
                    'ps' => $response->return->srv_bool->ps,
                    'pr' => $response->return->srv_bool->pr,
                    's10' => $response->return->srv_bool->s10,
                    's12' => $response->return->srv_bool->s12,
                    'sat' => $response->return->srv_bool->sat,
                    'ow' => $response->return->srv_bool->ow,
                    'srs' => $response->return->srv_bool->srs,
                    'sds' => $response->return->srv_bool->sds,
                    'cdx' => null,
                    'cdx_amount' => null,
                    'cdx_currency' => null,
                    'ado' => null,
                ]
            );

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->soapClient->getSoapClient()->__getLastRequest(),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get Service Countries Allowed SDS
     *
     * @return array|null
     */
    public function getServicesCountriesSDS(): ?array
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adeServices_GetCountriesSDS",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession()
                    ]
                ]
            );

            $validResult = $this->validApiResult($response->return->items);

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $validResult !== true
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        $validResult !== true
                            ? 'Unexpected API response: ' . $validResult
                            : 'API response: result is valid'
                    )
                );
            }

            if ($validResult !== true) {
                return null;
            }

            return $response->return->items;

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->soapClient->getSoapClient()->__getLastRequest(),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Get Parcel Shop by ID.
     *
     * @param string $id
     * @return ParcelShop|null
     */
    public function getParcelShopSearchByID(string $id): ?ParcelShop
    {
        try {
            $response = $this->soapClient->getSoapClient()->__soapCall(
                "adeParcelShop_SearchByID",
                [
                    'parameters' => [
                        'session' => $this->soapSession->getSoapSession(),
                        'id' => $id
                    ]
                ]
            );

            $validResult = $this->validApiResult($response->return, ParcelShop::class);

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $validResult !== true
                        ? $this->log::LOG_TYPE_ERROR
                        : $this->log::LOG_TYPE_INFO,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $this->toString($response->return),
                        $validResult !== true
                            ? 'Unexpected API response: ' . $validResult
                            : 'API response: result is valid'
                    )
                );
            }

            if ($validResult !== true) {
                return null;
            }

            return $this->parcelShopFactory->create(
                [
                    'id' => $response->return->id,
                    'name1' => $response->return->name1,
                    'name2' => $response->return->name2 ?: null,
                    'name3' => $response->return->name3 ?: null,
                    'country' => $response->return->country,
                    'zipcode' => $response->return->zipcode,
                    'city' => $response->return->city,
                    'street' => $response->return->street,
                ]
            );

        } catch (SoapFault $fault) {
            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS API',
                    sprintf(
                        '[%s] %s %s %s',
                        __METHOD__,
                        $this->toString($this->soapClient->getSoapClient()->__getLastRequest()),
                        $fault->faultcode,
                        $fault->faultstring
                    )
                );
            }
        }

        return null;
    }

    /**
     * Validate API result
     *
     * @param mixed $data
     * @param string|null $className
     * @param array|null $properties
     * @return bool|string
     */
    private function validApiResult(mixed $data, string $className = null, array $properties = null): bool|string
    {
        try {
            if (!is_array($data) && !is_object($data)) {
                return 'Data must be an array or an object.';
            }

            if ($className !== null && is_object($data) && !class_exists($className)) {
                return 'Class does not exist: ' . $className;
            }

            $nullableProperties = [];

            if ($className !== null && $properties === null) {
                $reflectionClass = new ReflectionClass($className);

                foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
                    $type = $prop->getType();

                    if ($type && $type->allowsNull()) {
                        $nullableProperties[$prop->getName()] = true;
                    }

                    $properties[] = $prop->getName();
                }
            }

            if ($properties !== null) {
                foreach ($properties as $propertyName) {
                    if (is_array($data)) {
                        if (!array_key_exists($propertyName, $data) && !isset($nullableProperties[$propertyName])) {
                            return "Key '{$propertyName}' is missing in the array.";
                        }
                    } elseif (is_object($data)) {
                        if (!property_exists($data, $propertyName) && !isset($nullableProperties[$propertyName])) {
                            return "Property '{$propertyName}' is missing in the object.";
                        }
                    }
                }
            }
        } catch (ReflectionException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Get string from mixed data
     *
     * @param mixed $data
     * @return string
     */
    private function toString(mixed $data): string
    {
        if (!is_string($data)) {
            return (string)$this->jsonSerializer->serialize($data);
        }

        return $data;
    }
}
