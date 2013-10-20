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
include "global.php" ;

$qr = db_query("select id,url from links_links where id='$id'");

if(db_num($qr)){

 if(!$HTTP_COOKIE_VARS["links_hits_$id"]){
 db_query("update links_links set hits=hits+1 where id='$id'");
 setcookie('links_hits_'.$id, "ok", time() + (60 * 60 * 24),"/");
 }
 $data = db_fetch($qr);

 header("Location: $data[url]");
        }else{
        site_header();
        open_table();
print "<center><font color=red> Œÿ√ : </font> —«»ÿ Œ«ÿÌ¡ </center>";
close_table();
site_footer();
}                  