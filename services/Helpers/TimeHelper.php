<?php

namespace Services\Helpers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class TimeHelper {
    private $businessStart;
    private $businessEnd;
    private $displayFormat;
    private static $instance;
    private $userTimeZone;
    private $businessTimeZone;
    private $timeDisplayFormat;
    private $dateDisplayFormat;

    private function __construct(){
        $this->businessTimeZone = 'America/Chicago';
        $this->businessStart = Carbon::now()->startOfDay()->setHour(9);
        $this->businessEnd = Carbon::now()->startOfDay()->setHour(17);
        $this->userTimeZone = session()->get('userTimezone') ?? 'America/Chicago';
        $this->timeDisplayFormat = 'g A';
        $this->dateDisplayFormat = 'D M d Y e';
    }

    public function getDateDisplayFormat() {
        return $this->dateDisplayFormat;
    }

    public static function get() {
        if (!isset(self::$instance)) {
            self::$instance = new TimeHelper();
        }

        return self::$instance;
    }

    public function getTimeDisplayFormat() {
        return $this->timeDisplayFormat;
    }

    public function getBusinessStart() {
        return $this->businessStart->copy()->setTimezone($this->userTimeZone);
    }

    public function getBusinessEnd() {
        return $this->businessEnd->copy()->setTimezone($this->userTimeZone);
    }

    public function getDisplayFormat() {
        return $this->displayFormat;
    }

    public function getUserTimeZone() {
        return $this->userTimeZone;
    }

    public function getBusinessTimeZone() {
        return $this->businessTimeZone;
    }

    public function isBetweenBusinessHours(Carbon $start, Carbon $end) {
        $businessStart = $start->copy()->setTimezone($this->businessTimeZone)->startOfDay()->setHour(9);
        $businessEnd = $start->copy()->setTimezone($this->businessTimeZone)->startOfDay()->setHour(17);
        return $start->between($businessStart, $businessEnd) && $end->between($businessStart, $businessEnd);
    }

    public function isOverlap(Carbon $start1, Carbon $end1, Carbon $start2, Carbon $end2) {
        $period1 = new CarbonPeriod($start1, $end1);
        $period2 = new CarbonPeriod($start2, $end2);

        return $period1->overlaps($period2);
    }

    public function getRandomAppointmentDate() {
        $days = rand(1, 60);
        $time = rand(9, 13);
        $date = Carbon::now()
            ->startOfDay()
            ->setHour($time);

        return $days % 2 === 0 ? $date->addDays($days) : $date->subDays($days);
    }

    public function fromStringToUser($dateString) {
        $business = new Carbon($dateString);
        return $business->setTimezone($this->userTimeZone)->format($this->dateDisplayFormat);
    }

    public function fromStringToUserObject($dateString) {
        $business = new Carbon($dateString);
        return $business->setTimezone($this->userTimeZone);
    }

    public function fromUserStringToAppObject($dateString) {
        $date = Carbon::parse($dateString);
        return $date->setTimezone($this->businessTimeZone);
    }

    public static function getUserNow() {
        return Carbon::now($this->userTimeZone);
    }

    public function displayUserDateAndTime($datestring) {
        $date = $this->fromStringToUserObject($datestring);
        return $date->format('D M d Y g A');
    }
}