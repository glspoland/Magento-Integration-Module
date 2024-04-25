<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Test\Unit\Helper;

use DateTime;
use DateTimeZone;
use Exception;
use GlsPoland\Shipping\Helper\DateHelper;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use PHPUnit\Framework\TestCase;

class DateHelperTest extends TestCase
{
    /** @var DateHelper */
    private DateHelper $dateHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $timezone = $this->createMock(TimezoneInterface::class);
        $this->dateHelper = new DateHelper($timezone);
    }

    /**
     * Data provider for getDate
     *
     * @return array[]
     */
    private function getDateDataProvider(): array
    {
        return [
            [
                '2021-01-01',
                'Y-m-d',
                true,
                '2021-01-01'
            ],
            [
                '2021-01-01',
                'Y-m-d',
                false,
                '2021-01-01'
            ],
            [
                $this->getNowDateTime('Y-m-d'),
                'Y-m-d',
                true,
                $this->getNowDateTime('Y-m-d')
            ],
            [
                $this->getNowDateTime('Y-m-d'),
                'Y-m-d',
                false,
                $this->getNowDateTime('Y-m-d')
            ],
            [
                '2000-01-01',
                'Y-m-d',
                true,
                '2000-01-01'
            ],
            [
                '2000-01-01',
                'Y-m-d',
                false,
                '2000-01-01'
            ],
            [
                '2021-01-01',
                'Y-m-d H:i:s',
                true,
                '2021-01-01 00:00:00'
            ],
            [
                '2021-01-01',
                'Y-m-d H:i:s',
                false,
                '2021-01-01 00:00:00'
            ],
            [
                $this->getNowDateTime('Y-m-d H:i:s'),
                'Y-m-d H:i:s',
                true,
                $this->getNowDateTime('Y-m-d H:i:s')
            ],
            [
                $this->getNowDateTime('Y-m-d H:i:s'),
                'Y-m-d H:i:s',
                false,
                $this->getNowDateTime('Y-m-d H:i:s')
            ],
            [
                '2000-01-01',
                'Y-m-d H:i:s',
                true,
                '2000-01-01 00:00:00'
            ],
            [
                '2000-01-01',
                'Y-m-d H:i:s',
                false,
                '2000-01-01 00:00:00'
            ],
        ];
    }

    /**
     * Data provider for checkIfWorkDay
     *
     * @return array[]
     */
    private function checkIfWorkDayDataProvider(): array
    {
        return [
            ['2000-12-25', true, false],
            ['2000-12-25', false, false],
            ['2000-01-01', true, false],
            ['2000-01-01', false, false],
            ['2000-04-24', true, false],
            ['2000-04-24', false, false],
            ['2000-05-01', true, false],
            ['2000-05-01', false, false],
            ['2000-05-03', true, false],
            ['2000-05-03', false, false],
            ['2000-08-15', true, false],
            ['2000-08-15', false, false],
            ['2000-11-01', true, false],
            ['2000-11-01', false, false],
            ['2000-11-11', true, false],
            ['2000-11-11', false, false],
            ['2000-03-15', true, true],
            ['2000-03-15', false, true],
            ['2000-06-07', true, true],
            ['2000-06-07', false, true],
            ['2000-09-11', true, true],
            ['2000-09-11', false, true],
            ['2000-11-20', true, true],
            ['2000-11-20', false, true],
        ];
    }

    /**
     * Data provider for getNextWorkDay
     *
     * @return array[]
     */
    private function getNextWorkDayDataProvider(): array
    {
        return [
            ['2000-12-25', true, '2000-12-27'],
            ['2000-12-25', false, '2000-12-27'],
            ['2000-01-01', true, '2000-01-03'],
            ['2000-01-01', false, '2000-01-03'],
            ['2000-04-24', true, '2000-04-25'],
            ['2000-04-24', false, '2000-04-25'],
            ['2000-05-01', true, '2000-05-02'],
            ['2000-05-01', false, '2000-05-02'],
            ['2000-05-03', true, '2000-05-04'],
            ['2000-05-03', false, '2000-05-04'],
            ['2000-08-15', true, '2000-08-16'],
            ['2000-08-15', false, '2000-08-16'],
            ['2000-11-01', true, '2000-11-02'],
            ['2000-11-01', false, '2000-11-02'],
            ['2000-11-11', true, '2000-11-13'],
            ['2000-11-11', false, '2000-11-13'],
            ['2000-03-15', true, '2000-03-16'],
            ['2000-03-15', false, '2000-03-16'],
            ['2000-06-07', true, '2000-06-08'],
            ['2000-06-07', false, '2000-06-08'],
            ['2000-09-11', true, '2000-09-12'],
            ['2000-09-11', false, '2000-09-12'],
            ['2000-11-20', true, '2000-11-21'],
            ['2000-11-20', false, '2000-11-21'],
        ];
    }

    /**
     * Data provider for checkIfHoliday
     *
     * @return array[]
     */
    private function checkIfHolidayDataProvider(): array
    {
        return [
            ['2000-12-25', true, true],
            ['2000-12-25', false, true],
            ['2000-01-01', true, true],
            ['2000-01-01', false, true],
            ['2000-04-24', true, true],
            ['2000-04-24', false, true],
            ['2000-05-01', true, true],
            ['2000-05-01', false, true],
            ['2000-05-03', true, true],
            ['2000-05-03', false, true],
            ['2000-08-15', true, true],
            ['2000-08-15', false, true],
            ['2000-11-01', true, true],
            ['2000-11-01', false, true],
            ['2000-11-11', true, true],
            ['2000-11-11', false, true],
            ['2000-03-15', true, false],
            ['2000-03-15', false, false],
            ['2000-06-07', true, false],
            ['2000-06-07', false, false],
            ['2000-09-11', true, false],
            ['2000-09-11', false, false],
            ['2000-11-20', true, false],
            ['2000-11-20', false, false],
        ];
    }

    /**
     * Test convert date data provider
     *
     * @dataProvider getDateDataProvider
     */
    public function testGetDate(mixed $date, string $format, bool $useTimezone, string $expected): void
    {
        $result = $this->dateHelper->getDate($date, $format, $useTimezone);
        $this->assertIsString($result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider checkIfWorkDayDataProvider
     */
    public function testCheckIfWorkDay(string $date, bool $useTimezone, bool $expected): void
    {
        $result = $this->dateHelper->checkIfWorkDay($date, $useTimezone);
        $this->assertIsBool($result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getNextWorkDayDataProvider
     */
    public function testGetNextWorkDay(string $date, bool $useTimezone, string $expected): void
    {
        $result = $this->dateHelper->getNextWorkDay($date, $useTimezone);
        $this->assertIsString($result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider checkIfHolidayDataProvider
     */
    public function testCheckIfHoliday(string $date, bool $useTimezone, bool $expected): void
    {
        $result = $this->dateHelper->checkIfHoliday($date, $useTimezone);
        $this->assertIsBool($result);
        $this->assertEquals($expected, $result);
    }

    /**
     * Get now date time
     *
     * @param string $format
     * @return string|null
     */
    private function getNowDateTime(string $format): ?string
    {
        try {
            return (new DateTime('now', new DateTimeZone('UTC')))->format($format);
        } catch (Exception $e) {
            return null;
        }
    }
}
