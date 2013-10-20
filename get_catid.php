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
if (check_login_cookies()) {
print "<html dir=rtl>
<title>ﬁ«∆„… «·√ﬁ”«„</title>
<LINK href='smiletag-admin.css' type=text/css rel=StyleSheet>";


if(!$cat){$cat=0;}


$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from links_cats where id=$dir_data[cat]");

        $dir_content = "<a href='get_catid.php?cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
  //------------------------------------------
    print "<br><p align=right><img src='images/link.gif'><a href='get_catid.php?cat=0'>«·—∆Ì”Ì… </a> / $dir_content</p>";

    $qr = db_query("select * from links_cats where cat='$cat'");


if(db_num($qr)){
 print "<center>
            <table width=90% class=grid><tr><td>";

         while($data = db_fetch($qr)){
      print "<li><a href='get_catid.php?cat=$data[id]'>$data[name]</a></li>
     ";
         }
    print "</td></tr></table></center>";

    }else{
            print "<center>
            <table width=70% class=grid><tr><td align=center> ·«  ÊÃœ √ﬁ”«„ ›—⁄Ì…</td></tr></table></center>";
            }

if($cat > 0){
print "<center><br><table width=80% class=grid><tr><td align=center>
<input type=submit value='«Œ Ì«— Â–« «·ﬁ”„' onClick=\"opener.sender.elements['cat_to'].value='$cat';window.close();\"></td></tr></table></center>";
}

}
