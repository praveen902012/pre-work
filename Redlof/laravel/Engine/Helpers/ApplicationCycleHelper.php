<?php
namespace Helpers;

class ApplicationCycleHelper
{

    public static function getLatestCycle()
    {

        $latest_cycle = \Models\ApplicationCycle::where('is_latest', true)->first();

        return $latest_cycle;
    }

    public static function getApplicationCycle($year)
    {

        $application_cycles = \Models\ApplicationCycle::where('session_year', $year)->get();

        return $application_cycles;
    }

    public static function getAllCycle()
    {

        $all_cycle = \Models\ApplicationCycle::all();

        return $all_cycle;
    }
}
