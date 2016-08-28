<?php

namespace SBG\ReportingBundle\Helper;

use DateTime;

/**
 * Nie dotykac, nie probowac zrozumiec.
 * W razie problemow pisac do episkopatu
 * 
 *
 * @author aaugustyniak
 */
class PolishPublicHolidaysHelper
{

    private $festDays = array(
        1 => "Nowy Rok",
        6 => "Trzech Króli",
    );

    public function isLeap($year)
    {
        return !($year % 4) && (($year % 100) || !($year % 400));
    }

    /**
     * Czy dzień jest wolny
     * @param type $day
     * @return boolean
     */
    public function isFest($day)
    {
        $dateObj = $this->parseParam($day);
        $year = intval($dateObj->format('Y'));
        $nthDayOfYear = intval($dateObj->format('z')) + 1;
        $this->initMovableFestsFor($year);
        if (isset($this->festDays[$nthDayOfYear])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Czy dzień jest pracujący
     * @param type $day
     * @return type
     */
    public function isWorkingDay($day)
    {
        return !$this->isFest($day);
    }

    private function parseParam($param)
    {
        if ($param instanceof DateTime) {
            return $param;
        } else if (is_string($param)) {
            return new DateTime($param);
        } else {
            throw new \InvalidArgumentException();
        }
    }

    private function initMovableFestsFor($year)
    {
        $leapYearStep = ($this->isLeap($year)) ? 1 : 0;
        $easterFirstDay = $this->findFirstEasterDayIn($year);
        $this->festDays[$easterFirstDay] = "Niedziela Wielkanocna";
        $this->festDays[1 + $easterFirstDay] = "Poniedziałek Wielkanocny";
        $this->festDays[121 + $leapYearStep] = "święto Pracy";
        $this->festDays[123 + $leapYearStep] = "Trzeciego Maja";
        $this->festDays[$easterFirstDay + 49] = "Zesłanie Ducha Świętego";
        $this->festDays[$easterFirstDay + 60] = "Boże Ciało";
        $this->festDays[305 + $leapYearStep] = "Wszystkich Świętych";
        $this->festDays[315 + $leapYearStep] = "Święto niepodległości";
        $this->festDays[359 + $leapYearStep] = "Boże Narodzenie I";
        $this->festDays[360 + $leapYearStep] = "Boże Narodzenie II";
    }

    private function findFirstEasterDayIn($year)
    {
        $leapYearStep = ($this->isLeap($year)) ? 1 : 0;
        $w1 = $year % 19;
        $w2 = (int) ($year / 100);
        $w3 = $year % 100;
        $w4 = (int) ($w2 / 4);
        $w5 = $w2 % 4;
        $w6 = (int) (($w2 + 8) / 25);
        $w7 = (int) (($w2 - $w6 + 1) / 3);
        $w8 = (19 * $w1 + $w2 - $w4 - $w7 + 15) % 30;
        $w9 = (int) ($w3 / 4);
        $w10 = $w3 % 4;
        $w11 = (32 + 2 * $w5 + 2 * $w9 - $w8 - $w10) % 7;
        $w12 = (int) (($w1 + 11 * $w8 + 22 * $w11) / 451);
        $w13 = ($w8 + $w11 - 7 * $w12 + 114);
        $dayNymber = -33 + $w13 + $leapYearStep;
        return $dayNymber;
    }

}
