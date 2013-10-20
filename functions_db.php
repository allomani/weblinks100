<?
/**
 *  Allomani Weblinks v1.0
 * 
 * @package Allomani.Weblinks
 * @version 1.0
 * @copyright (c) 2006-2013 Allomani , All rights reserved.
 * @author Ali Allomani <info@allomani.com>
 * @link http://allomani.com
 * @license GNU General Public License version 3.0 (GPLv3)
 * 
 */

 function sort_by($array,  $keyname = null) {
   $myarray = $inarray = array();
   foreach ($array as $i => $befree) {
       $myarray[$i] = $array[$i][$keyname];
   }
   asort($myarray);
   foreach ( $myarray as $key=> $befree) {
       $inarray[$key] = $array[$key];
   }
   return $inarray;
}


   function db_query($sql){
        return mysql_query($sql) ;
           }
    function db_fetch($qr){

            return mysql_fetch_array($qr);
            }
    function db_qr_fetch($sql){
     
            return mysql_fetch_array(mysql_query($sql));
            }

              function db_num($sql){
         
            return mysql_num_rows($sql);
            }

             function db_qr_num($sql){
             
            return mysql_num_rows(mysql_query($sql));
            }