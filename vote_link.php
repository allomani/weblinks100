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



if($vote_num && $id){
$vote_num = intval($vote_num);
$id = intval($id);

if(!$HTTP_COOKIE_VARS["links_vote_$id"]){
db_query("update links_links set votes=votes+$vote_num , votes_total=votes_total+1 where id='$id'");
setcookie('links_vote_'.$id, "ok", time() + (60 * 60 * 24),"/");
}

print "<html dir=$settings[html_dir]>";
print "<title> ÊŞííã ãæŞÚ </title>";
print "<LINK href='style.css' type=text/css rel=StyleSheet>";

open_table("ÊŞííã ãæŞÚ");
print "<center>   ÔßÑÇ áß áŞÏ Êã ÊŞííã ÇáãæŞÚ </center>";
close_table();

        }else{
print "<html dir=$settings[html_dir]>";
print "<title> ÊŞííã ãæŞÚ </title>";
print "<LINK href='style.css' type=text/css rel=StyleSheet>";

open_table("ÊŞííã ãæŞÚ");
$id = intval($id);
                print "
<form action='vote_link.php' method=post>
<input type=hidden name=id value=$id>
<center>
<table width=50%>
<tr><td width=30%>
ÇáÊŞííã : </td>
<td>
<select name=vote_num>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
</select>
</td>
<td><input type=submit value='ÊŞííã'></td>
</tr>

</table></form>";
close_table();
}