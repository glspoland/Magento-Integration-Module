<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\ParcelShop;

use GlsPoland\Shipping\Model\ApiHandler;
use GlsPoland\Shipping\Model\Checkout\Processor;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface as CartRepository;

class Save extends Action
{
    public const PARCEL_SHOP_ID_COLUMN_NAME = 'gls_poland_parcel_shop_id';
    public const SCOPE = 'scope';
    public const QUOTE_ID = 'quote_id';
    public const ADMIN_RESOURCE = 'GlsPoland_Shipping::gls_courier';

    /** @var ApiHandler */
    protected ApiHandler $apiHandler;

    /** @var Processor */
    protected Processor $checkoutProcessor;

    /** @var CheckoutSession */
    protected CheckoutSession $checkoutSession;

    /** @var RequestInterface */
    protected RequestInterface $request;

    /** @var JsonFactory */
    protected JsonFactory $resultJsonFactory;

    /** @var CartRepository */
    protected CartRepository $quoteResourceModel;

    /**
     * Class constructor.
     *
     * @param CartRepository $quoteResourceModel
     * @param CheckoutSession $checkoutSession
     * @param ApiHandler $apiHandler
     * @param RequestInterface $request
     * @param Processor $checkoutProcessor
     * @param JsonFactory $resultJsonFactory
     * @param Context $context
     */
    public function __construct(
        CartRepository $quoteResourceModel,
        CheckoutSession $checkoutSession,
        ApiHandler $apiHandler,
        RequestInterface $request,
        Processor $checkoutProcessor,
        JsonFactory $resultJsonFactory,
        Context $context
    ) {
        parent::__construct($context);

        $this->quoteResourceModel = $quoteResourceModel;
        $this->checkoutSession = $checkoutSession;
        $this->apiHandler = $apiHandler;
        $this->request = $request;
        $this->checkoutProcessor = $checkoutProcessor;
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

        try {
            $parcelShopId = (string)$this->request->getParam(self::PARCEL_SHOP_ID_COLUMN_NAME);
            $scope = (string)$this->request->getParam(self::SCOPE);
            $quoteId = $this->request->getParam(self::QUOTE_ID);

            if (!empty($parcelShopId)) {
                $parcelShop = $this->apiHandler->getParcelShopSearchByID($parcelShopId);

                if ($parcelShop !== null) {
                    if ($scope === 'frontend') {
                        $quote = $this->checkoutSession->getQuote();
                    } elseif ($scope === 'backend' && !empty($quoteId)) {
                        $quote = $this->quoteResourceModel->get($quoteId);
                    } else {
                        return $result->setData(['status' => 0]);
                    }

                    $this->checkoutProcessor->setParcelShop($parcelShop, $quote);

                    return $result->setData(['status' => 1]);
                }
            }
        } catch (LocalizedException|NoSuchEntityException $e) {
            return $result->setData(
                [
                    'status' => 0,
                    'error' => $e->getMessage()
                ]
            );
        }

        return $result->setData(['status' => 0]);
    }

    /**
     * Check Permission.
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return true;
    }
}
