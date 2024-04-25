<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Helper;

use DateTime;
use DateTimeZone;
use Exception;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class DateHelper
{
    /**  @var TimezoneInterface */
    protected TimezoneInterface $timezone;

    /**
     * Class constructor.
     *
     * @param TimezoneInterface $timezone
     */
    public function __construct(TimezoneInterface $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * Convert date to string to given format
     *
     * @param string|null $date
     * @param string $format
     * @param bool $useTimezone
     * @return string|null
     */
    public function getDate(string $date = null, string $format = 'Y-m-d H:i:s', bool $useTimezone = true): ?string
    {
        try {
            $timezone = $useTimezone ? $this->timezone->getConfigTimezone() : 'UTC';
            $dateTimeZone = $timezone !== null ? new DateTimeZone($timezone) : null;

            return (new DateTime($date ?? 'now', $dateTimeZone))->format($format);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get next work day
     *
     * @param string|null $date
     * @param bool $useTimezone
     * @return string
     */
    public function getNextWorkDay(string $date = null, bool $useTimezone = true): string
    {
        try {
            $timezone = $useTimezone ? $this->timezone->getConfigTimezone() : 'UTC';
            $dateTimeZone = $timezone !== null ? new DateTimeZone($timezone) : null;

            $dateTime = (new DateTime($date ?? 'now', $dateTimeZone));
            $dateTime->modify('+1 day');

            while (!$this->checkIfWorkDay($dateTime->format('Y-m-d'))) {
                $dateTime->modify('+1 day');
            }

            return $dateTime->format('Y-m-d');

        } catch (Exception $e) {
            return $date;
        }
    }

    /**
     * Check if given date is work day
     *
     * @param string|null $date
     * @param bool $useTimezone
     * @return bool|null
     */
    public function checkIfWorkDay(string $date = null, bool $useTimezone = true): ?bool
    {
        try {
            $timezone = $useTimezone ? $this->timezone->getConfigTimezone() : 'UTC';
            $dateTimeZone = $timezone !== null ? new DateTimeZone($timezone) : null;
            $weekDay = (int)(new DateTime($date ?? 'now', $dateTimeZone))->format('N');

            return $weekDay >= 1 && $weekDay <= 5 && $this->checkIfHoliday($date, $useTimezone) === false;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Check if given date is holiday
     *
     * @param string|null $date
     * @param bool $useTimezone
     * @return bool
     */
    public function checkIfHoliday(string $date = null, bool $useTimezone = true): bool
    {
        try {
            $timezone = $useTimezone ? $this->timezone->getConfigTimezone() : 'UTC';
            $dateTimeZone = $timezone !== null ? new DateTimeZone($timezone) : null;
            $year = (int)(new DateTime($date ?? 'now', $dateTimeZone))->format('Y');

            $holidays = $this->getHolidaysInPoland($year, $useTimezone);
            $compareDate = $this->getDate($date, 'Y-m-d');

            return in_array($compareDate, $holidays, true);

        } catch (Exception $e) {
            return true;
        }
    }

    /**
     * Get holidays in Poland
     *
     * @param int $year
     * @param bool $useTimezone
     * @return string[]|null
     */
    private function getHolidaysInPoland(int $year, bool $useTimezone = true): ?array
    {
        try {
            $timezone = $useTimezone ? $this->timezone->getConfigTimezone() : 'UTC';
            $dateTimeZone = $timezone !== null ? new DateTimeZone($timezone) : null;

            $holidays = [
                "$year-01-01",
                "$year-01-06",
                "$year-05-01",
                "$year-05-03",
                "$year-08-15",
                "$year-11-01",
                "$year-11-11",
                "$year-12-25",
                "$year-12-26",
            ];

            $easterDate = (new DateTime(date('Y-m-d', easter_date($year)), $dateTimeZone))->format('Y-m-d');
            $holidays[] = $easterDate;

            $easterPlusOneDay = date('Y-m-d', strtotime("$easterDate +1 day"));
            $holidays[] = (new DateTime($easterPlusOneDay))->format('Y-m-d');

            $easterPlusFortyNineDays = date('Y-m-d', strtotime("$easterDate +49 days"));
            $holidays[] = (new DateTime($easterPlusFortyNineDays))->format('Y-m-d');

            $easterPlusSixtyDays = date('Y-m-d', strtotime("$easterDate +60 days"));
            $holidays[] = (new DateTime($easterPlusSixtyDays))->format('Y-m-d');

            return $holidays;

        } catch (Exception $e) {
            return null;
        }
    }
}
