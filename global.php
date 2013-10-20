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
$version_number = "1.0" ;
//-----------------------------
define("GLOBAL_LOADED",true);
//-----------------------------
if (!defined('CWD')){define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));}
//---------------------------------------------
require(CWD . "/config.php") ;

   //--------- DO NOT CHANGE -----------------------
 if (!empty($HTTP_POST_VARS)) {extract($HTTP_POST_VARS);}
if (!empty($HTTP_GET_VARS)) {extract($HTTP_GET_VARS);}
if (!empty($HTTP_ENV_VARS)) {extract($HTTP_ENV_VARS);}
$PHP_SELF=$_SERVER[PHP_SELF];


function if_admin($dep=""){
        global $user_info ;

        if(!$dep){
        if($user_info['groupid'] != 1){
         die ("<center> ·Ì” ·œÌﬂ  ’—ÌÕ ·œŒÊ· Â–Â «·„‰ÿﬁ… </center>");
         }
          }else{
           if($user_info['groupid'] != 1){

                  $data=db_qr_fetch("select * from songs_user where id=$user_info[id]");
                  if(!$data["perm_$dep"]){
                           die ("<center> ·Ì” ·œÌﬂ  ’—ÌÕ ·œŒÊ· Â–Â «·„‰ÿﬁ… </center>");
                          }
                 }
            }
         }

function get_image($src){
         if($src){
              return $src ;
            }else{

    return "images/no_pic.gif" ;
    }
    }



//---------------------------
mysql_connect($db_host,$db_username,$db_password) or die("connection Error");
mysql_select_db($db_name) or die("Database Name Error");
//--------------------------------------
 include "functions_db.php" ;
include "theme.php" ;
include "counter.php";



function print_copyrights(){
                global $_SERVER,$sitename ;
print "<p align=center><span lang=\"ar-sa\"><font>Ã„Ì⁄ «·ÕﬁÊﬁ „Õ›ÊŸ… ·‹ : </font>
<a target=\"_blank\" href=\"http://$_SERVER[SERVER_NAME]\">$sitename</a> © " . date('Y') . " <br>
                        »—„Ã… <a target=\"_blank\" href=\"http://allomani.com/\">
                        <font>«··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ… </font></a><font>
                        © 2006</font></span></font>\n";

        }
$settings = array();
//--------------- Get Settings --------------------------
function load_settings(){
global  $settings ;
$qr = db_query("select * from links_settings");
while($data = db_fetch($qr)){

$settings["$data[name]"] = $data['value'] ;
        }
}
//-------------------------------------------------------
load_settings();

$sitename = $settings['sitename'] ;
$section_name = $settings['section_name'] ;


function read_file($filename){
$fn = fopen($filename,"r");
$fdata = fread($fn,filesize($filename));
fclose($fn);
return $fdata ;
}

function execphp_fix_tag($match)
{
        // replacing WPs strange PHP tag handling with a functioning tag pair
        $output = '<?php'. $match[2]. '?>';
        return $output;
}

function run_php($content)
{

$content = str_replace(array("&#8216;", "&#8217;"), "'",$content);
$content = str_replace(array("&#8221;", "&#8220;"), '"', $content);
$content = str_replace("&Prime;", '"', $content);
$content = str_replace("&prime;", "'", $content);
        // for debugging also group unimportant components with ()
        // to check them with a print_r($matches)
        $pattern = '/'.
                '(?:(?:<)|(\[))[\s]*\?php'. // the opening of the <?php or [?php tag
                '(((([\'\"])([^\\\5]|\\.)*?\5)|(.*?))*)'. // ignore content of PHP quoted strings
                '\?(?(1)\]|>)'. // the closing ? > or ?] tag
                '/is';
      $content = preg_replace_callback($pattern, 'execphp_fix_tag', $content);
        // to be compatible with older PHP4 installations
        // don't use fancy ob_XXX shortcut functions
        ob_start();
        eval(" ?> $content ");
        $output = ob_get_contents();
        ob_end_clean();
        print $output;
}
$user_info = array();
function check_login_cookies(){
      global $user_info,$HTTP_COOKIE_VARS ;

      $user_info['username'] = $HTTP_COOKIE_VARS['links_username'];
$user_info['password'] = $HTTP_COOKIE_VARS['links_password'];
$user_info['id'] = $HTTP_COOKIE_VARS['links_id'];
$user_info['groupid'] = $HTTP_COOKIE_VARS['links_group_id'];


   if($user_info['id']){
   $qr = db_query("select * from links_user where id=$user_info[id]");
         if(db_num($qr)){
           $data = db_fetch($qr);
           if($data['username'] == $user_info['username'] && md5($data['password']) == $user_info['password']){
                 $user_info['groupid'] = $data['group_id'];

                   return true ;
                   }else{
                           return false ;
                           }

                 }else{
                         return false ;
                         }

           }else{
                   return false ;
                   }
        
        }

//--------------------Get_cats---------------------------
function get_cats($id){
  $cats_arr = array();
   $cats_arr[]=$id;

         $qr1 = db_query("select id from links_cats where cat=$id");
         while($data1 = db_fetch($qr1)){
          $cats_arr[]=$data1['id'] ;
          $qr2=db_query("select id from links_cats where cat=$data1[id]");
          while($data2 = db_fetch($qr2)){
           $cats_arr[]=$data2['id'] ;
           $qr3=db_query("select id from links_cats where cat=$data2[id]");
          while($data3 = db_fetch($qr3)){
           $cats_arr[]=$data3['id'] ;
           $qr4=db_query("select id from links_cats where cat=$data2[id]");
          while($data4 = db_fetch($qr4)){
           $cats_arr[]=$data4['id'] ;
                  }
                  }
                  }
          }
          return  $cats_arr ;
         }
//---------------------Get Link Class---------------------------
function get_link_class($class_id,$link_text){

        if($class_id){

     $qr = db_query("select * from links_classes where id='$class_id'");
     if(db_num($qr)){

    $data = db_fetch($qr);
    $content = $data['before'].$link_text.$data['after'];
    return $content ;
             }else{
            return $link_text ;
                     }
                }else{
      return $link_text ;
      }
        }