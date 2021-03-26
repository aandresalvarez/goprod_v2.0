<?php

/**
 * Created by Alvaro Alvarez.
 * User: alvaro1
 * Date: 3/7/17
 * Time: 5:48 PM
 *
 *  global $Proj; -->set to catch the project information when use
 *
 */

namespace Stanford\GoProd;
use \REDCap as REDCap;
class check_pi_irb_type
{
    /**
     * @param $Proj
     * @return array --True if the PI is found in the research project
     */
    public static function MissingPI()
    {
        global $Proj;
        $first_name = trim($Proj->project['project_pi_firstname']);
        $last_name = trim($Proj->project['project_pi_lastname']);
        $purpose = trim($Proj->project['purpose']);
        $where = "Project Setup ";//TODO: create the lang file variable
        $issue = "PI is missing";
        $link = '<a target="_blank" class="btn btn-link" href=" ' . APP_PATH_WEBROOT . 'ProjectSetup/index.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
        $array = self::CreateResultArray($where, $issue, $link);
        if ($purpose === "2" and strlen($first_name) == 0 and strlen($last_name) == 0) {
            return $array;// with results - this is a JustFor fun project.
        } else {
            return array(); // no results. this is a real project
        }


    }

    /**
     * @param $Proj
     * @return array -- True if the IRB Number is set
     */
    public static function MissingIRB()
    {
        global $Proj;
        $irb_number = $Proj->project['project_irb_number'];
        $where = "Project Setup $irb_number";//TODO: create the lang file variable
        $issue = "IRB is missing";
        $link = '<a target="_blank" class="btn btn-link" href=" ' . APP_PATH_WEBROOT . 'ProjectSetup/index.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
        $array = self::CreateResultArray($where, $issue, $link);
        $purpose = $Proj->project['purpose'];
        if ($purpose === "2" and strlen(trim($irb_number)) == 0) {
            return $array;// with results - this is a JustFor fun project.
        } else {
            return array(); // no results. this is a real project
        }
    }

    /**
     * @param $Proj
     * @return array --
     */
    public static function IsAResearchProject()
    { // "2" for research
        global $Proj;

        $where = "Project Setup";//TODO: create the lang file variable
        $issue = "This project is not for research";
        $link = '<a target="_blank" class="btn btn-link" href=" ' . APP_PATH_WEBROOT . 'ProjectSetup/index.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
        $array = self::CreateResultArray($where, $issue, $link);
        $purpose = $Proj->project['purpose'];
        if ($purpose !== "2" and $purpose !== "0") {
            return $array;// with results - this is a JustFor fun project.
        } else {
            return array(); // no results. this is a real project
        }

    }

    /**
     * @param $Proj
     * @return array
     */
    public static function IsJustForFunProject()
    { // "0" forFun
        global $Proj;

        $where = "Project Setup";//TODO: create the lang file variable
        $issue = "Not for fun project can not be moved to production mode";
        $link = '<a target="_blank" class="btn btn-link" href=" ' . APP_PATH_WEBROOT . 'ProjectSetup/index.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
        $array = self::CreateResultArray($where, $issue, $link);
        $purpose = $Proj->project['purpose'];
        if ($purpose === "0") {
            return $array;// with results - this is a JustFor fun project.
        } else {
            return array(); // no results. this is a real project
        }
    }

    public static function CreateResultArray($where, $issue, $link)
    {
        $tmp = array();
        array_push($tmp, $where, $issue, $link);
        $tmp1[0] = $tmp;
        return $tmp1;
    }

    /*  EM@partners.org
        Adding the check of Neither Research nor Quality Improvement*/
    public static function IsRxOrQI()
    { // "0" forFun
        global $Proj;

        $where = "Project Setup";//TODO: create the lang file variable
        $issue = "Not for fun project can not be moved to production mode";
        $link = '<a target="_blank" class="btn btn-link" href=" ' . APP_PATH_WEBROOT . 'ProjectSetup/index.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
        $array = self::CreateResultArray($where, $issue, $link);
        $purpose = $Proj->project['purpose'];

        //If not Research AND not Quality Improvement
        if ($purpose !== "2" && $purpose !== "3") {
            return $array;// Either a Practice, Operational Support, or Other Project
        } else {
            return array(); // no results. This is either Research OR Quality Improvement
        }
    }
}