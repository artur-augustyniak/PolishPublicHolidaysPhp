<?php

namespace SBG\ReportingBundle\Tests\Services;

use SBG\ReportingBundle\Helper\PolishPublicHolidaysHelper;
use Symfony\Bundle\WebProfilerBundle\Tests\TestCase;

/**
 * @author aaugustyniak
 */
class TestPolishFestsHelper extends TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFestsWithNorStringOrDateTime()
    {
        $festHelper = new PolishPublicHolidaysHelper();
        $rubbish = 1231423;
        $festHelper->isFest($rubbish);
    }

    /**
     * @expectedException \Exception
     */
    public function testFestsWithUnparsableString()
    {
        $festHelper = new PolishPublicHolidaysHelper();
        $rubbish = "ohamburgerfonsz";
        $festHelper->isFest($rubbish);
    }

    public function testFestsWithString()
    {
        $param = $this->provenFests[0];
        $festHelper = new PolishPublicHolidaysHelper();
        $decission = $festHelper->isFest($param);
        $this->assertTrue($decission);
    }

    public function testFestsWithObject()
    {
        $param = new \DateTime($this->provenFests[0]);
        $festHelper = new PolishPublicHolidaysHelper();
        $decission = $festHelper->isFest($param);
        $this->assertTrue($decission);
    }

    public function testLeapYearIndicator()
    {
        $festHelper = new PolishPublicHolidaysHelper();
        foreach ($this->leapYears as $year) {
            $decission = $festHelper->isLeap($year);
            $this->assertTrue($decission);
        }
        foreach ($this->nonLeapYears as $year) {
            $decission = $festHelper->isLeap($year);
            $this->assertFalse($decission);
        }
    }

    public function testProvenFests()
    {
        $festHelper = new PolishPublicHolidaysHelper();
        foreach ($this->provenFests as $dateStr) {
            $decission = $festHelper->isFest($dateStr);
            $this->assertTrue($decission);
        }
    }

    public function testProvenWorkingDays()
    {

        $festHelper = new PolishPublicHolidaysHelper();
        foreach ($this->provenWorkingDays as $dateStr) {
            $decission = $festHelper->isWorkingDay($dateStr);
            $this->assertTrue($decission);
        }
    }

    private $leapYears = array(
        2008,
        2012
    );
    private $nonLeapYears = array(
        2009,
        2010
    );
    private $provenWorkingDays = array(
        '2011-06-13',
        '2011-06-14',
        '2011-06-15',
        '2011-06-16',
        '2011-06-17',
        '2011-06-18',
    );
    private $provenFests = array(
        '2011-01-01',
        '2011-01-06',
        '2011-04-24',
        '2011-04-25',
        '2011-05-01',
        '2011-05-03',
        '2011-06-12',
        '2011-06-23',
        '2011-11-01',
        '2011-11-11',
        '2011-12-25',
        '2011-12-26',
        '2013-01-01',
        '2013-01-06',
        '2013-03-31',
        '2013-04-01',
        '2013-05-01',
        '2013-05-03',
        '2013-05-19',
        '2013-05-30',
        '2013-11-01',
        '2013-11-11',
        '2013-12-25',
        '2013-12-26',
    );

}
