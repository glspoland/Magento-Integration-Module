<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Config;

use DOMDocument;
use GlsPoland\Shipping\Helper\ConfigHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;
use Netresearch\ShippingCore\Api\InfoBox\VersionInterface;
use stdClass;
use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Framework\App\Config\Storage\WriterInterface;

class Config implements VersionInterface
{
    public const MODULE_ENABLE = 'carriers/glspoland/active';
    /*
     * TODO: Set RELEASE_NOTES URL
     */
    private const RELEASE_NOTES = 'https://commercemarketplace.adobe.com/gls-shipping-m2.html#product.info.details.release_notes';//phpcs:ignore
    private const CONFIG_PATH_VERSION = 'carriers/glspoland/version';
    /*
     * TODO: Set MODULE_INSTRUCTIONS URL
     */
    private const MODULE_INSTRUCTIONS = 'https://commercemarketplace.adobe.com/gls-shipping-m2.html#product.info.details.tech_specs';//phpcs:ignore
    public const MODULE_MODE = 'carriers/glspoland/mode';
    private const MODULE_NAME = 'GlsPoland_Shipping';
    public const SANDBOX_WSDL = 'https://ade-test.gls-poland.com/adeplus/pm1/ade_webapi2.php?wsdl';//phpcs:ignore
    public const SANDBOX_USER = 'carriers/glspoland/api_sandbox_username';
    public const SANDBOX_PASSWORD = 'carriers/glspoland/api_sandbox_password';
    public const PROD_WSDL = 'https://adeplus.gls-poland.com/adeplus/pm1/ade_webapi2.php?wsdl';//phpcs:ignore
    public const PROD_USER = 'carriers/glspoland/api_prod_username';
    public const PROD_PASSWORD = 'carriers/glspoland/api_prod_password';
    public const INTEGRATOR_ID = 'qa3o99l0gt4ue510';
    private const USE_ALTERNATIVE_SENDER_ADDRESS = 'carriers/glspoland/use_alternative_sender_address';
    private const SENDER_ADDRESS_NAME1 = 'carriers/glspoland/sender_address_name1';
    private const SENDER_ADDRESS_NAME2 = 'carriers/glspoland/sender_address_name2';
    private const SENDER_ADDRESS_NAME3 = 'carriers/glspoland/sender_address_name3';
    private const SENDER_ADDRESS_COUNTRY = 'carriers/glspoland/sender_address_country';
    private const SENDER_ADDRESS_ZIP = 'carriers/glspoland/sender_address_zipcode';
    private const SENDER_ADDRESS_CITY = 'carriers/glspoland/sender_address_city';
    private const SENDER_ADDRESS_STREET = 'carriers/glspoland/sender_address_street';
    private const CONFIG_PATH_DEBUG = 'carriers/glspoland/debug';
    public const CONFIG_PACKAGE_WEIGHT = 'carriers/glspoland/package_weight';
    private const CONFIG_PACKAGE_COMMENTS = 'carriers/glspoland/package_comments';
    private const CONFIG_PACKAGE_REFERENCES = 'carriers/glspoland/package_references';
    private const CONFIG_ALLOW_SPECIFIC = 'carriers/glspoland/allow_specific';
    private const GENERAL_COUNTRY_ALLOW = 'general/country/allow';
    private const CONFIG_SPECIFIC_COUNTRY = 'carriers/glspoland/specific_country';
    private const CONFIG_PATH_TITLE = 'carriers/glspoland/title';
    private const CONFIG_PATH_ORDER_STATUS_AFTER_LABEL_PRINT_ACTIVE = 'order_status_after_label_print_active';
    private const CONFIG_PATH_ORDER_STATUS_AFTER_LABEL_PRINT = 'order_status_after_label_print';
    private const CONFIG_PATH_LABEL = 'carriers/glspoland/label';
    private const CONFIG_PATH_MAX_COD = 'carriers/glspoland/max_cod';
    private const CONFIG_PATH_COUNTRIES_SDS = 'carriers/glspoland/countries_sds';
    private const CONFIG_PATH_STORE_NAME = 'general/store_information/name';
    private const CONFIG_PATH_STORE_STREET1 = 'general/store_information/street_line1';
    private const CONFIG_PATH_STORE_STREET2 = 'general/store_information/street_line2';
    private const CONFIG_PATH_STORE_POSTCODE = 'general/store_information/postcode';
    private const CONFIG_PATH_STORE_CITY = 'general/store_information/city';
    private const CONFIG_PATH_STORE_COUNTRY_ID = 'general/store_information/country_id';
    private const CONFIG_PATH_STORE_PHONE = 'general/store_information/phone';

    /** @var ScopeConfigInterface */
    private ScopeConfigInterface $scopeConfig;

    /** @var ConfigHelper */
    private ConfigHelper $configHelper;

    /** @var EncryptorInterface */
    protected EncryptorInterface $encryptor;

    /** @var SerializerInterface */
    protected SerializerInterface $serializer;

    /** @var WriterInterface */
    protected WriterInterface $writerInterface;

    /**
     * Class constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ConfigHelper $configHelper
     * @param EncryptorInterface $encryptor
     * @param SerializerInterface $serializer
     * @param WriterInterface $writerInterface
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ConfigHelper $configHelper,
        EncryptorInterface $encryptor,
        SerializerInterface $serializer,
        WriterInterface $writerInterface
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->configHelper = $configHelper;
        $this->encryptor = $encryptor;
        $this->serializer = $serializer;
        $this->writerInterface = $writerInterface;
    }

    /**
     * Get module enable
     *
     * @return bool
     */
    public function getModuleEnable(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::MODULE_ENABLE);
    }

    /**
     * Get Carrier Title
     *
     * @return string
     */
    public function getCarrierTitle(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_TITLE);
    }

    /**
     * Get debug config.
     *
     * @return bool
     */
    public function isDebugEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_PATH_DEBUG);
    }

    /**
     * Get Sender Address Type
     *
     * @return bool
     */
    public function getUseAlternativeSenderAddress(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::USE_ALTERNATIVE_SENDER_ADDRESS);
    }

    /**
     * Prepare Sender Address object using config fields.
     *
     * @return stdClass
     */
    public function getSenderAddress(): stdClass
    {
        $senderAddress = new stdClass();
        $senderAddress->name1 = (string)$this->scopeConfig->getValue(
            self::SENDER_ADDRESS_NAME1
        );
        $senderAddress->name2 = (string)$this->scopeConfig->getValue(
            self::SENDER_ADDRESS_NAME2
        );
        $senderAddress->name3 = (string)$this->scopeConfig->getValue(
            self::SENDER_ADDRESS_NAME3
        );
        $senderAddress->country = (string)$this->scopeConfig->getValue(
            self::SENDER_ADDRESS_COUNTRY
        );
        $senderAddress->zipcode = (string)$this->scopeConfig->getValue(
            self::SENDER_ADDRESS_ZIP
        );
        $senderAddress->city = (string)$this->scopeConfig->getValue(
            self::SENDER_ADDRESS_CITY
        );
        $senderAddress->street = (string)$this->scopeConfig->getValue(
            self::SENDER_ADDRESS_STREET
        );

        return $senderAddress;
    }

    /**
     * Prepare Sender Address object using config fields form Magento
     *
     * @return stdClass
     */
    public function getStoreSenderAddress(): stdClass
    {
        $senderAddress = new stdClass();
        $senderAddress->name = (string)$this->scopeConfig->getValue(
            self::CONFIG_PATH_STORE_NAME
        );

        $street1 = (string)$this->scopeConfig->getValue(
            self::CONFIG_PATH_STORE_STREET1
        );
        $street2 = (string)$this->scopeConfig->getValue(
            self::CONFIG_PATH_STORE_STREET2
        );

        $senderAddress->street = $street1 . $street2 ?? $street2;

        $senderAddress->zipcode = (string)$this->scopeConfig->getValue(
            self::CONFIG_PATH_STORE_POSTCODE
        );
        $senderAddress->city = (string)$this->scopeConfig->getValue(
            self::CONFIG_PATH_STORE_CITY
        );
        $senderAddress->country = (string)$this->scopeConfig->getValue(
            self::CONFIG_PATH_STORE_COUNTRY_ID
        );
        $senderAddress->phone = (string)$this->scopeConfig->getValue(
            self::CONFIG_PATH_STORE_PHONE
        );

        return $senderAddress;
    }

    /**
     * Get Sandbox or Prod mode.
     *
     * @return string|null
     */
    public function getModuleMode(): ?string
    {
        return $this->scopeConfig->getValue(self::MODULE_MODE);
    }

    /**
     * Get Module name.
     *
     * @return string
     */
    public function getModuleName(): string
    {
        return self::MODULE_NAME;
    }

    /**
     * Get Wsdl string
     *
     * @return string
     */
    public function getWsdl(): string
    {
        return $this->getModuleMode() === 'sandbox' ? self::SANDBOX_WSDL : self::PROD_WSDL;
    }

    /**
     * Get Username from config.
     *
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return  $this->getModuleMode() === 'sandbox' ?
            $this->scopeConfig->getValue(self::SANDBOX_USER) :
            $this->scopeConfig->getValue(self::PROD_USER);
    }

    /**
     * Get Password from config.
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        $password = $this->getModuleMode() === 'sandbox' ?
            $this->scopeConfig->getValue(self::SANDBOX_PASSWORD) :
            $this->scopeConfig->getValue(self::PROD_PASSWORD);

        return $this->encryptor->decrypt($password);
    }

    /**
     * Get IntegratorId from config.
     *
     * @return string
     */
    public function getIntegratorId(): string
    {
        return self::INTEGRATOR_ID;
    }

    /**
     * Get Module version from config.
     *
     * @return string
     */
    public function getModuleVersion(): string
    {
        return (string)$this->scopeConfig->getValue(self::CONFIG_PATH_VERSION);
    }

    /**
     * Get Shipping Method Active
     *
     * @param string $shippingCode
     * @return bool
     */
    public function getShippingMethodActive(string $shippingCode): bool
    {
        return (bool)$this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/active'
        );
    }

    /**
     * Set Shipping Method Active
     *
     * @param string $value
     * @param string $shippingCode
     * @return void
     */
    public function setShippingMethodActive(string $value, string $shippingCode): void
    {
        $this->writerInterface->save(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/active',
            $value
        );
    }

    /**
     * Get Shipping Method COD
     *
     * @param string $shippingCode
     * @return bool
     */
    public function getShippingMethodCod(string $shippingCode): bool
    {
        return (bool)$this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/cod'
        );
    }

    /**
     * Set Shipping Method COD
     *
     * @param string $value
     * @param string $shippingCode
     * @return void
     */
    public function setShippingMethodCod(string $value, string $shippingCode): void
    {
        $this->writerInterface->save(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/cod',
            $value
        );
    }

    /**
     * Get Shipping Method Name
     *
     * @param string $shippingCode
     * @return string|null
     */
    public function getShippingMethodName(string $shippingCode): ?string
    {
        return $this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/name'
        );
    }

    /**
     * Get Shipping Method Title
     *
     * @param string $shippingCode
     * @return string|null
     */
    public function getShippingMethodTitle(string $shippingCode): ?string
    {
        return $this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/title'
        );
    }

    /**
     * Get Shipping Method Sort Order
     *
     * @param string $shippingCode
     * @return int
     */
    public function getShippingMethodPosition(string $shippingCode): int
    {
        $sortOrder = $this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/position'
        );

        if ($sortOrder !== null) {
            return (int)$sortOrder;
        }

        return 1;
    }

    /**
     * Get Free Shipping Price
     *
     * @param string $shippingCode
     * @return string|null
     */
    public function getShippingPrice(string $shippingCode): ?string
    {
        return (string)$this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/price'
        );
    }

    /**
     * Get Free Shipping Enable
     *
     * @param string $shippingCode
     * @return bool
     */
    public function getFreeShippingEnable(string $shippingCode): bool
    {
        return (bool)$this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/free_shipping_enable'
        );
    }

    /**
     * Get Free Shipping Subtotal
     *
     * @param string $shippingCode
     * @return string|null
     */
    public function getFreeShippingSubtotal(string $shippingCode): ?string
    {
        return (string)$this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/free_shipping_subtotal'
        );
    }

    /**
     * Get Default Package weight
     *
     * @param string $shippingCode
     * @return float
     */
    public function getDefaultPackageWeight(string $shippingCode): float
    {
        $weight = (string)$this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/weight'
        );

        return $this->configHelper->toFloat($weight);
    }

    /**
     * Get Default References
     *
     * @param string $shippingCode
     * @return string|null
     */
    public function getDefaultReference(string $shippingCode): ?string
    {
        $reference = $this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/reference'
        );

        if (!empty($reference)) {
            return (string)$reference;
        }

        return null;
    }

    /**
     * Get Default Comments
     *
     * @param string $shippingCode
     * @return string
     */
    public function getDefaultComment(string $shippingCode): string
    {
        return (string)$this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/comment'
        );
    }

    /**
     * Get Allow Specific
     *
     * @param string $shippingCode
     * @return bool
     */
    public function getAllowSpecific(string $shippingCode): bool
    {
        return (bool)$this->scopeConfig->getValue(
            ShippingMethods::METHODS[$shippingCode]['config_path'] . '/allow_specific'
        );
    }

    /**
     * Get Specific Country
     *
     * @param string $shippingCode
     * @return string[]
     */
    public function getSpecificCountry(string $shippingCode): array
    {
        if ($this->getAllowSpecific($shippingCode)) {
            $countryList = (string)$this->scopeConfig->getValue(
                ShippingMethods::METHODS[$shippingCode]['config_path'] . '/specific_country'
            );
        } else {
            $countryList = (string)$this->scopeConfig->getValue(
                self::GENERAL_COUNTRY_ALLOW
            );
        }

        if (empty($countryList)) {
            return ['PL'];
        }

        return explode(',', $countryList);
    }

    /**
     * Get Version from marketplace.
     *
     * @return string
     */
    public function getConfigVersionInformation(): string
    {
        $result = '';
        $dom = new DOMDocument();
        $dom->loadHTML(self::RELEASE_NOTES);
        $releaseNotesElement = $dom->getElementById('release_notes');

        if ($releaseNotesElement) {
            $h3Elements = $releaseNotesElement->getElementsByTagName('h3');

            if ($h3Elements->length > 0) {
                $firstH3 = $h3Elements->item(0)->textContent;

                if ($firstH3 === $this->getModuleVersion()) {
                    $result = __('The version of the module is up to date.');
                } else {
                    $result = __('Updates are available, check what you get by updating the plugin:')
                        . ' <a href="' . self::RELEASE_NOTES . '" target="_blank">'
                        . __('Change log.') . '</a>';
                }
            }
        } else {
            $result = __('No information about the module version.');
        }

        return (string)$result;
    }

    /**
     * Get Release notes link.
     *
     * @return string
     */
    public function getConfigReleaseNotesLink(): string
    {
        return self::RELEASE_NOTES;
    }

    /**
     * Get instructions from marketplace link.
     *
     * @return string
     */
    public function getInstructions(): string
    {
        return self::MODULE_INSTRUCTIONS;
    }

    /**
     * Get Order Status After Label Print Active
     *
     * @return bool
     */
    public function getOrderStatusAfterLabelPrintActive(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::CONFIG_PATH_ORDER_STATUS_AFTER_LABEL_PRINT_ACTIVE
        );
    }

    /**
     * Get Order Status After Label Print
     *
     * @return string|null
     */
    public function getOrderStatusAfterLabelPrint(): ?string
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_ORDER_STATUS_AFTER_LABEL_PRINT
        );
    }

    /**
     * Get shipping label
     *
     * @return string|null
     */
    public function getShippingLabelType(): ?string
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_LABEL
        );
    }

    /**
     * Set Max COD value
     *
     * @param float|null $value
     * @return void
     */
    public function setServicesMaxCOD(?float $value): void
    {
        $this->writerInterface->save(self::CONFIG_PATH_MAX_COD, $value);
    }

    /**
     * Get Max COD value
     *
     * @return float|null
     */
    public function getServicesMaxCOD(): ?float
    {
        return $this->configHelper->toFloat(
            $this->scopeConfig->getValue(
                self::CONFIG_PATH_MAX_COD
            )
        );
    }

    /**
     * Set Services Countries SDS
     *
     * @param array|null $value
     * @return void
     */
    public function setServicesCountriesSDS(?array $value): void
    {
        $countryList = implode(',', $value);
        $this->writerInterface->save(self::CONFIG_PATH_COUNTRIES_SDS, $countryList);
    }

    /**
     * Get Services Countries SDS
     *
     * @return array
     */
    public function getServicesCountriesSDS(): array
    {
        $countryList = (string)$this->scopeConfig->getValue(self::CONFIG_PATH_COUNTRIES_SDS);

        if (empty($countryList)) {
            return ['PL'];
        }

        return explode(',', $countryList);
    }
}
