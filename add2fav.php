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

 $id = intval($id);
 
print "<html dir='$settings[html_dir]'>";
print "<title> «÷«›… ··„›÷·… </title>";
print "<LINK href='style.css' type=text/css rel=StyleSheet>";
?>
<script>

        
function add2fav2(){
    var title = document.forms['frm'].elements['name'].value;
    var url = document.forms['frm'].elements['url'].value; 
    
    
if (window.sidebar) // firefox
 window.sidebar.addPanel(title, url, "");
else if(window.opera && window.print){ // opera
 var elem = document.createElement('a');
 elem.setAttribute('href',url);
 elem.setAttribute('title',title);
 elem.setAttribute('rel','sidebar');
 elem.click();
} 
else if(document.all)// ie
 window.external.AddFavorite(url, title);
}
</script>
<?



open_table("«÷«›… ··„›÷·…");
$qr = db_query("select url,name from links_links where id='$id'");
if(db_num($qr)){
$data = db_fetch($qr);
print "
<form  method=post onSubmit=\"add2fav2();return false;\" name=frm>
<input type=hidden name=id value=$id>
<center>
<table width=100%>
<tr><td width=30%>
«·«”„  : </td>
<td><input type=text name='name' value='$data[name]' size=30>
</td></tr>

<tr><td width=30%>
«·—«»ÿ  : </td>
<td><input type=text name='url' dir=ltr value='$data[url]' size=30>
</td></tr>

<tr><td colspan=2 align=center><input type=submit  value='«÷«›…'></td>
</tr>

</table></form>";
}else{
print "<center>  Ì—ÃÏ «· √ﬂœ „‰ «·—«»ÿ </center>";
        }
close_table();
