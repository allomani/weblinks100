<?php
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


//========================================================================================
if((ereg("Nav", getenv("HTTP_USER_AGENT"))) || (ereg("Gold", getenv("HTTP_USER_AGENT"))) || (ereg("X11", getenv("HTTP_USER_AGENT"))) || (ereg("Mozilla", getenv("HTTP_USER_AGENT"))) || (ereg("Netscape", getenv("HTTP_USER_AGENT"))) AND (!ereg("MSIE", getenv("HTTP_USER_AGENT")) AND (!ereg("Konqueror", getenv("HTTP_USER_AGENT"))))) $browser = "Netscape";
elseif(ereg("MSIE", getenv("HTTP_USER_AGENT"))) $browser = "MSIE";
elseif(ereg("Lynx", getenv("HTTP_USER_AGENT"))) $browser = "Lynx";
elseif(ereg("Opera", getenv("HTTP_USER_AGENT"))) $browser = "Opera";
elseif(ereg("WebTV", getenv("HTTP_USER_AGENT"))) $browser = "WebTV";
elseif(ereg("Konqueror", getenv("HTTP_USER_AGENT"))) $browser = "Konqueror";
elseif((eregi("bot", getenv("HTTP_USER_AGENT"))) || (ereg("Google", getenv("HTTP_USER_AGENT"))) || (ereg("Slurp", getenv("HTTP_USER_AGENT"))) || (ereg("Scooter", getenv("HTTP_USER_AGENT"))) || (eregi("Spider", getenv("HTTP_USER_AGENT"))) || (eregi("Infoseek", getenv("HTTP_USER_AGENT")))) $browser = "Bot";
else $browser = "Other";


/* Get the Operating System data */

if(ereg("Win", getenv("HTTP_USER_AGENT"))) $os = "Windows";
elseif((ereg("Mac", getenv("HTTP_USER_AGENT"))) || (ereg("PPC", getenv("HTTP_USER_AGENT")))) $os = "Mac";
elseif(ereg("Linux", getenv("HTTP_USER_AGENT"))) $os = "Linux";
elseif(ereg("FreeBSD", getenv("HTTP_USER_AGENT"))) $os = "FreeBSD";
elseif(ereg("SunOS", getenv("HTTP_USER_AGENT"))) $os = "SunOS";
elseif(ereg("IRIX", getenv("HTTP_USER_AGENT"))) $os = "IRIX";
elseif(ereg("BeOS", getenv("HTTP_USER_AGENT"))) $os = "BeOS";
elseif(ereg("OS/2", getenv("HTTP_USER_AGENT"))) $os = "OS/2";
elseif(ereg("AIX", getenv("HTTP_USER_AGENT"))) $os = "AIX";
else $os = "Other";

/* Save on the databases the obtained values */

db_query("update info_browser set count=count+1 where name='$browser'");
db_query("update info_os set count=count+1 where name='$os'");

$dot = date("d-m-Y");

$result=db_query("select hits from info_hits where date='$dot'");

if (mysql_num_rows($result)){
db_query("update info_hits set hits=hits+1 where date='$dot'");
 }else{
  db_query("insert into info_hits (date,hits) values ('$dot','1')");
         }


// «·Êﬁ  «·„⁄ÿÏ ·ﬂ· „ ’›Õ ·Õ”«» „œ… ÊÃÊœÂ »«·„Êﬁ⁄ - »«·ÀÊ«‰Ì
$timeoutseconds="800";


   $ip = getenv("REMOTE_ADDR");
     //  $ip = "213.25.52.40";

    $time=time();
$timeout=$time-$timeoutseconds;
//$file=$_SERVER['PHP_SELF'];



    db_query("DELETE FROM info_online WHERE time<$timeout");


$sm=split("/",str_replace(".","/",$ip));
$ip_max = trim("$sm[0].$sm[1].$sm[2]");
  //  $ip_max = $ip ;


    $result = db_query("SELECT * FROM info_online WHERE ip like '$ip_max%'");


    if (mysql_num_rows($result)) {
        db_query("UPDATE info_online SET time='$time', ip='$ip' WHERE ip like '$ip_max%'");
    } else {
        db_query("INSERT INTO info_online (time,ip) VALUES ('$time', '$ip')");
    }


// »œ¡ Õ”«» ⁄œœ «·„ ’›ÕÌ‰ Õ«·Ì«

 //================

$result=db_query("SELECT DISTINCT ip FROM info_online ");
$users=mysql_num_rows($result);


// ⁄—÷ ⁄œœ «·„ ’›ÕÌ‰ Õ«·Ì«


//=========Best Visitors Record ==============================================
$now_dt = date("d-M-Y")." «·”«⁄… : " .date("H:i");
 $data=db_qr_fetch("select v_count from info_best_visitors");

 if ($users > $data['v_count']){

  $counter['best_visit'] = $users ;
   $counter['best_visit_time'] = $now_dt ;

  db_query("update info_best_visitors set v_count='$users',time='$now_dt'");

 }else{
$best=db_qr_fetch("select * from info_best_visitors");
   $counter['best_visit'] = $best['v_count'] ;
   $counter['best_visit_time'] =  $best['time'];

 }
//==========================================================================

$counter['online_users'] = $users ;



?>