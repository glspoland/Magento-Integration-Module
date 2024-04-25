<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model\CourierForm;

use GlsPoland\Shipping\Helper\DateHelper;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as UiComponentDataProvider;

class DataProvider extends UiComponentDataProvider
{
    /** @var DateHelper */
    protected DateHelper $dateHelper;

    /**
     * Class constructor.
     *
     * @param DateHelper $dateHelper
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        DateHelper $dateHelper,
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder
        );

        $this->dateHelper = $dateHelper;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        return [
            'receipt_date_start_date' => $this->dateHelper->getNextWorkDay()
        ];
    }
}
