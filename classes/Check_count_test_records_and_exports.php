<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/7/17
 * Time: 5:45 PM
 */

namespace Stanford\GoProd;
use \REDCap as REDCap;
// connect to the REDCap database
 //require_once '../../../redcap_connect.php';

//NOTICE: when the project is moved to production made the Survey Responses and created records are deleted
// If the project is a copy then the log is reset to 0. that is ok since you may need to test this new project.



/*
 * Me parece robusta tu solución, creo que esta bien asi. Lo único seria ver si puede esto ser mas claro para el usuario, tal vez como dices, poniendo “tested records”
 * y yo agregaría abajo alguna nota: “tested records do not include any recrods that could have been imported into the project when it was created”.
 *  Algo asi…  Me alegro de que todo esta funcionando bien!
 *
 * */





class check_count_test_records_and_exports
{




    /**
     * @param $string
     * @return mixed|string
     */
    public static function CleanString($string){

        // first preparing the strings.
        //for $string1
        //remove spaces at the end and convert in lowercase
        $word1=trim(strtolower($string));
        //remove spaces between words
        $word1 = str_replace(' ', '_', $word1);
        //remove tabs
        $word1 = preg_replace('/\s+/','_',$word1);
        $word1 = str_replace('__', '_', $word1);

        return $word1;
    }


    /**
     * @return array // Return  Array with number of exports an records created.
     */
    public static function CheckTestRecordsAndExports( ){

        //project information
        $create_record_array=Array(self::CleanString('Create survey response (Auto calculation)'),self::CleanString('Create survey response'),self::CleanString('Created Response'),self::CleanString('Create record'),self::CleanString('Create record (API)'),self::CleanString( 'Create record (API) (Auto calculation)'),self::CleanString('Create record (Auto calculation)'),self::CleanString('Create record (import)'));
        $export_data_array=Array(self::CleanString('Export data'),self::CleanString('Export data (API Playground)'),self::CleanString( 'Export data (API)'),self::CleanString('Export data (CSV raw with return codes)'));
        $count_records=0;
        $count_exports=0;
        $total= Array();
        $sql = "SELECT description FROM redcap_log_event where project_id=".$_GET['pid'];
        $result = db_query( $sql );
        while ( $result1 = db_fetch_assoc( $result ) )
        {
            if(in_array(self::CleanString($result1[description]), $create_record_array)           ){
                $count_records++;
            }elseif (in_array(self::CleanString($result1[description]),$export_data_array)){
                $count_exports++;
            }
        }
          if($count_records < 3 or $count_exports < 1) { $total=  Array($count_exports,$count_records); }
            return $total;
}


}