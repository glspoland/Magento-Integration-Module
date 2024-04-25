<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model\ResourceModel\Log;

use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;
use GlsPoland\Shipping\Model\Log;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Psr\Log\LoggerInterface;

class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'id';

    /** @var Log */
    protected Log $log;

    /** @var TimezoneInterface */
    private TimezoneInterface $timezone;

    /**
     * Class constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param Log $log
     * @param TimezoneInterface $timezone
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        Log $log,
        TimezoneInterface $timezone,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);

        $this->log = $log;
        $this->timezone = $timezone;
    }

    /**
     * Init Resource Model.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            \GlsPoland\Shipping\Model\Log::class,
            \GlsPoland\Shipping\Model\ResourceModel\Log::class
        );
    }

    /**
     * Clear logs by last 30 days.
     *
     * @return void
     */
    public function clearLogsByDays(): void
    {
        try {
            $timezone = $this->timezone->getConfigTimezone();
            $date = new DateTime('now', new DateTimeZone($timezone));
            $date->sub(new DateInterval('P30D'));
            $formattedDate = $date->format('Y-m-d H:i:s');

            $connection = $this->getConnection();
            $tableName = $this->getMainTable();

            $whereCondition = 'created_at < \'' . $formattedDate . '\'';
            $connection->delete($tableName, $whereCondition);
        } catch (Exception $e) {
            $this->log->add(
                $this->log::LOG_TYPE_ERROR,
                'Database',
                sprintf(
                    '[%s] %s',
                    __METHOD__,
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Clear logs.
     *
     * @return void
     */
    public function clearLog(): void
    {
        $this->getConnection()->truncateTable($this->getMainTable());
    }
}
