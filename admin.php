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

//----------- Login Script ----------------------------------------------------------
if ($action == "login" && $username && $password ){
     $result=db_query("select * from links_user where username='$username'");
     if(mysql_num_rows($result)){
     $login_data=db_fetch($result);


       if($login_data['password']==$password){

       setcookie('links_id', $login_data['id'], time() + (60 * 60 * 24 * 30),"/");
       setcookie('links_username', $login_data['username'], time() + (60 * 60 * 24 * 30),"/");
        setcookie('links_password', md5($login_data['password']), time() + (60 * 60 * 24 * 30),"/");

      setcookie('links_group_id', $login_data['group_id'], time() + (60 * 60 * 24 * 30),"/");
    //  header("Location: admin.php");
       print "<SCRIPT>window.location=\"admin.php\";</script>";
      exit();
       }else{
         open_table();
              print "<center> ﬂ·„… «·„—Ê— €Ì— ’ÕÌÕ… </center>";
              close_table();
              }
            }else{
            open_table();
                    print "<center>  «”„ «·„” Œœ„ €Ì— ’ÕÌÕ </center>";
                    close_table();
                    }
              }elseif($action == "logout"){
                    setcookie('links_id', "", time() + (60 * 60 * 24 * 30),"/");
                    setcookie('links_username', "", time() + (60 * 60 * 24 * 30),"/");
                    setcookie('links_password', "", time() + (60 * 60 * 24 * 30),"/");
                     print "<SCRIPT>window.location=\"admin.php\";</script>";
                    //header("Location: admin.php");
                     // die( "<center>  „  ”ÃÌ· «·Œ—ÊÃ  <br><br> <a href='admin.php'>—ÃÊ⁄ </a></center>") ;
                      }
//-------------------------------------------------------------------------------------------




if (check_login_cookies()) {

?>
<html dir=rtl>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
<meta http-equiv="Content-Language" content="ar-sa" />

<title> <? print $sitename ;?> - ·ÊÕ… «· Õﬂ„ </title>
<script>
function cats_list()
{

msgwindow=window.open("get_catid.php","displaywindow","toolbar=no,scrollbars=yes,resizable=yes,width=400,height=300,top=200,left=200")
}
</script>
<link href="smiletag-admin.css" type=text/css rel=stylesheet>
<?
if(file_exists(CWD . "/install/")){
print "<div style=\"border:1px solid;color: #D8000C;background-color: #FFBABA;padding:3px;text-align:center;margin:0;\">Installation folder exists at /install , Please delete it</div>";
}
        
if($license_properties['expire']['value'] && $license_properties['expire']['value'] != "0000-00-00"){
    $remaining_days = floor((strtotime($license_properties['expire']['value']) - time()) / (24*60*60));
    print "<div style=\"border:1px solid;color: #9F6000;background-color: #F9F0B5;padding:3px;text-align:center;margin:0;direction:ltr;\">The license will expire on : {$license_properties['expire']['value']} ($remaining_days days)</div>";
}
?>
<table width=100% height=100%><tr><td width=20% valign=top>

√Â·« Ê ”Â·« »ﬂ Ì« <? print $HTTP_COOKIE_VARS['links_username'];?> <br><br>

<? include "admin_menu.html" ; ?>


</td>
 <td width=1 background='images/dot.gif'></td>
<td valign=top> <br>
<?
//----------------------Start -------------------------------------------------------
if(!$action || $action=="link_active"){
 if($action=="link_active"){
  db_query("update links_links set active=1 where id='$id'");
         }

  print "<center><table width=50% class=grid><tr><td align=center><b>√Â·« »ﬂ ›Ì ·ÊÕ… «· Õﬂ„ <br><br>

  „—Œ’ ·‹ : $_SERVER[SERVER_NAME]   „‰ <a href='http://allomani.com/' target='_blank'>  «··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ… </a> <br><br>
    «’œ«— : $version_number
  </td></tr></table>
  <br><p class=title> „Ê«ﬁ⁄  ‰ Ÿ— «·„Ê«›ﬁ… </p>
  <table width=70% class=grid>";
  $qr = db_query("select name,id,url from links_links where active=0");
  while($data = db_fetch($qr)){
  print "<tr><td><a href='$data[url]'>$data[name]</td><td align=center><a href='admin.php?action=link_active&id=$data[id]'> ›⁄Ì·</a></td><td align=center>
  <a href='admin.php?action=link_edit&id=$data[id]'> ⁄œÌ·</a> - <a href='processing.php?action=link_del&id=$data[id]' onclick=\"confirm('Â· «‰  „ √ﬂœ ø')\">Õ–›</a></td></tr>";
          }
          print "</table></center>";

   }

//---------------------------------------- Classes --------------------------------------------------
 if($action=="classes"){
   if_admin();
   print "<p align=center class=title> «·√‰„«ÿ </p>";


   print "<center>
   <form action=processing.php method=post>
   <input type=hidden name=action value='class_add_ok'>
   <table width=40% class=grid><tr><td><b>«·«”„ : </b></td><td>
   <input type=text name=name></td></tr>
   <tr><td><b> „„Ì“ </b></td><td><select name=special><option value=0>·«</option>
   <option value=1>‰⁄„</option></select></td></tr>
   <tr><td><b> «·ﬂÊœ ﬁ»· «·—«»ÿ </b></td><td><textarea name='before' dir=ltr cols=20 rows=3></textarea></td></tr>
      <tr><td><b> «·ﬂÊœ »⁄œ «·—«»ÿ </b></td><td><textarea name='after' dir=ltr cols=20 rows=3></textarea></td></tr>
     <tr><td colspan=2 align=center><input type=submit value='«÷«›…'></td></tr>
      </table>  <br>
   <table width=60% class=grid>";

   $qr = db_query("select * from links_classes");

   if(db_num($qr)){
           while($data = db_fetch($qr)){
           print "<tr><td>$data[name]</td>
            <td align=left><a href='admin.php?action=class_edit&id=$data[id]'> ⁄œÌ· </a> -
       <a href='processing.php?action=class_del&id=$data[id]' onclick=\"confirm('„ √ﬂœ „‰ «·Õ–› ø ');\">Õ–›</a></td></tr>";

                   }
                   }else{
                           print "<tr><td><center>  ·«  ÊÃœ √‰„«ÿ </center></td></tr>";
                           }
        print "</table></center>";
         }
 //---------------------------
 if($action=="class_edit"){

  $qr = db_query("select * from links_classes where id='$id'");

  if(db_num($qr)){
    $data = db_fetch($qr);
      print " <center> <form action=processing.php method=post>
   <input type=hidden name=id value='$data[id]'>
    <input type=hidden name=action value='class_edit_ok'>

   <table width=40% class=grid><tr><td><b>«·«”„ : </b></td><td>
   <input type=text name=name value='$data[name]'></td></tr>
   <tr><td><b> „„Ì“ </b></td><td><select name=special>" ;
  if($data['special']==1){$chk2="selected";}else{$chk1="selected";}

   print "<option value=0 $chk1>·«</option>
   <option value=1 $chk2>‰⁄„</option>

   </select></td></tr>
   <tr><td><b> «·ﬂÊœ ﬁ»· «·—«»ÿ </b></td><td><textarea name='before' dir=ltr cols=20 rows=3>$data[before]</textarea></td></tr>
      <tr><td><b> «·ﬂÊœ »⁄œ «·—«»ÿ </b></td><td><textarea name='after' dir=ltr cols=20 rows=3>$data[after]</textarea></td></tr>
     <tr><td colspan=2 align=center><input type=submit value=' ⁄œÌ·'></td></tr>
      </table>  " ;
       }
         }


//----------------- link Move -------
if($action == "link_move"){
if_admin();

 if($link_id){

 print "<form action=admin.php method=post name=sender>
 <input type=hidden name=action value='link_move_ok'>
 <input type=hidden name=cat value='$cat'>
 <center><table width=60% class=grid><tr><td colspan=2><b> ‰ﬁ· „‰ : </b>";

//-----------------------------------------
$data_from['cat'] = $cat ;
while($data_from['cat']>0){
   $data_from = db_qr_fetch("select name,id,cat from links_cats where id='$data_from[cat]'");

        $data_from_txt = "$data_from[name] / ". $data_from_txt  ;

        }
   print "$data_from_txt";
//------------------------------------------

 print "</td></tr>";

$data_movie=db_qr_fetch("select name from links_links where id='$link_id'");
  print "<input type=hidden name=link_id value='$link_id'>";
        print "<tr><td width=2><b>$c</b></td><td>$data_movie[name]</td></tr>"  ;


 print "<tr><td colspan=2><b>‰ﬁ· «·Ï ﬁ”„ —ﬁ„ : </b><input type=text size=4 name=cat_to>
 <a href=\"javascript:cats_list()\">
  <img src='images/list.gif' alt='ﬁ«∆„… «·√ﬁ”«„' border=0></a>
  </td></tr>
 <tr><td colspan=2 align=center><input type=submit value=' ‰ﬁ· «·—«»ÿ '></td></tr>
 </form>
 </table>";
        }else{
                print "<center>  Ì—ÃÏ  ÕœÌœ «·„Êﬁ⁄ √Ê·« </center>";
                }
        }
// ----------------------- Cats -------------------------------
if($action=="cats" || $action=="link_move_ok"){
        if_admin();

if($action=="link_move_ok"){

        $qr = db_query("select id from links_cats where id='$cat_to'");
        if(db_num($qr)){
        db_query("update links_links set cat='$cat_to' where id='$link_id'");
                }else{
                        print "<b> Œÿ√ : </b> ·„ Ì „ ‰ﬁ· «·„Êﬁ⁄ , Ì—ÃÏ «· √ﬂœ „‰ —ﬁ„ «·ﬁ”„ ";
                        }
                }


        if(!$cat){
                $cat=0;
               $cat_name = "«·ﬁ”„ «·—∆Ì”Ì ";
                }else{

   $qr_cat=db_query("select * from links_cats where id='$cat'");
   if(db_num($qr_cat)){
   $data_cat = db_fetch($qr_cat) ;

   $cat_name = $data_cat['name'];
   }else{
    $cat_name = "" ;
    }
    }

   if($cat_name){
  print "<center><p class=title>«·√ﬁ”«„ </p>
   <form method=\"POST\" action=\"processing.php\">
    <input type=hidden name=cat value='$cat'>
   <table width=40% class=grid><tr>
   <td> <b> «·≈”„ : </b>
    <input type=hidden name='action' value='cat_add_ok'></td><td>
   <input type=text name=name size=30>
    </td></tr>
    <tr><td> <b> «·ﬁ”„ : </b></td><td>$cat_name</td></tr>
    <tr><td colspan=2 align=center><input type=submit value='«÷«›…'></td></tr>
    </tr></table>

       </form>

   </center><br>";
//---------------------------------------------------------

 if($cat > 0){
$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from links_cats where id=$dir_data[cat]");

        $dir_content = "<a href='admin.php?action=cats&cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
        }

print "<p align=right><img src='images/link.gif'><a href='admin.php?action=cats&cat=0'>«·—∆Ì”Ì… </a> / $dir_content</p>";

 $qr = db_query("select * from links_cats where cat='$cat'");
 print "<center><table width=80% class=grid>";
 if(db_num($qr)){
 while($data = db_fetch($qr)){
     $addon_txt = "" ;

    $sub_cnt = db_qr_fetch("select count(id) as count from links_cats where cat='$data[id]'");
   $links_cnt = db_qr_fetch("select count(id) as count from links_links where cat='$data[id]'");

    if($sub_cnt['count'] > 0){
    $addon_txt = "<font size=2> ( $sub_cnt[count] ﬁ”„ ›—⁄Ì ) </font> &nbsp;&nbsp;" ;
   }
   if($links_cnt['count'] > 0){
    $addon_txt .= "<font size=2> ( $links_cnt[count] „Êﬁ⁄ ) </font>" ;
           }
      print "<tr><td><a  href='admin.php?action=cats&cat=$data[id]'>$data[name]</a>&nbsp; $addon_txt</td>
      <td><a href='admin.php?action=cat_edit&id=$data[id]&cat=$cat'> ⁄œÌ· </a></td>
      <td><a href=\"processing.php?action=cat_del&id=$data[id]&cat=$cat\" onClick=\"return confirm('Are you sure you want to delete ?');\">Õ–› </a></td>
      ";
         }
         }else{
                 print "<tr><td align=center>  ·«  ÊÃœ «ﬁ”«„ ›—⁄Ì… </td></tr>";
                 }
       print "</table>";
      if($cat>0){
       print "<p align=center class=title>  «·—Ê«»ÿ </p><a href='admin.php?action=links_add&cat=$cat'> «÷«›… —Ê«»ÿ </a><br><br>";
       print "<table width=80% class=grid>" ;
       $qr = db_query("select name,id,cat from links_links where cat='$cat'");
       if(db_num($qr)){
               while($data = db_fetch($qr)){
       print "<tr><td>$data[name]</a></td>
       <td align=left><a href='admin.php?action=link_edit&id=$data[id]&cat=$data[cat]'> ⁄œÌ· </a> -
       <a href='processing.php?action=link_del&id=$data[id]&cat=$data[cat]' onclick=\"confirm('„ √ﬂœ „‰ «·Õ–› ø ');\">Õ–›</a></td></tr>";
       }
               }else{
                       print "<tr><td align=center> ·«  ÊÃœ —Ê«»ÿ ›Ì Â–« «·ﬁ”„ </td></tr>";
                       }
       print"</table>";
       }
       }else{
             print "<center><table width=80% class=grid>";
               print "<tr><td align=center>  Â–« «·ﬁ”„ €Ì— „ÊÃÊœ </td></tr>";
                  print "</table>";
               }
        }
  //--------------------------- Links Add Form -------------------------------------------------
   if($action=="links_add"){
  $qr_cat = db_query("select name from links_cats where id='$cat'");
  if(db_num($qr_cat)){
          $data_cat = db_fetch($qr_cat) ;
          print "<p align=center class=title> «÷«›… —Ê«»ÿ ›Ì : $data_cat[name]</p>" ;

 if(!$add_limit){
$add_limit = $settings['links_add_limit'] ;
  }


  print " <center>
  <form method=\"POST\" action=\"admin.php\">

      <input type=\"hidden\" name=\"cat\" value='$cat'>
      <input type=hidden name=action value=links_add>
      <table width=30% class=grid>
      <tr><td align=center> ⁄œœ «·ÕﬁÊ· : <input type=text name=add_limit value='$add_limit' size=3>
      &nbsp;&nbsp;<input type=submit value=' ⁄œÌ·'></td></tr></table></form>

      <br>


  <form method=\"POST\" action=\"processing.php\" name=\"sender\">
<div align=\"center\">
<input type=\"hidden\" name=\"action\" value=\"links_add_ok\">

      <input type=\"hidden\" name=\"cat\" value=\"$cat\">

        <input type=hidden name=add_limit value='$add_limit'>

                <table  class=grid cellspacing=\"0\" width=\"90%\" >
                                                <tr>
                                    <td width=\"10\">#</td>
                                <td width=\"15%\" >
                                <p align=\"center\"><b>«”„ «·„Êﬁ⁄</b></td>
                                <td width=\"30%\" >
                                <p align=\"center\"><b>—«»ÿ «·„Êﬁ⁄</b></td>
                                   <td width=\"20%\" >
                                <p align=\"center\"><b>Ê’›</b></td>
                                 <td align=center> <b>  ‰„ÿ „Œ’’ </b></td>


                        </tr>
                        <tr><td colspan=5 height=1 background='images/dot.gif'></td></tr>\n";

                      for ($i=1;$i<=$add_limit;$i++){

                     print "   <tr>
                     <td><b>$i</b></td>
                                <td  >
                                <p align=\"center\">
                                <input type=\"text\" name=\"name[$i]\"  size=\"25\">
                                </td>
                                <td align=center>
                               <input type=\"text\" name=\"url[$i]\" size=\"30\" dir=ltr></td>


     <td>
      <textarea name=\"description[$i]\" cols=15 rows=1></textarea></td>

                                  <td align=center>
                                 <select name='class[$i]'>
    <option value='0'>»œÊ‰</option>
    ";
    $qr2=db_query("select * from links_classes");
    while($data2 = db_fetch($qr2)){
       print "<option value='$data2[id]'>$data2[name]</option>";

            }
    print "</select> </td>

                        </tr><tr><td colspan=5 height=1 background='images/dot.gif'></td></tr> " ;
                        }

                            print "   <tr><td colspan=5 align=center>
<input type=\"submit\" value=\"≈÷«›… «·—Ê«»ÿ\" name=\"B1\">
</td></tr>
                </table>


        </form>\n";

}else{
        print "<center>  «·ﬁ”„ €Ì— „ÊÃÊœ </center>";

        }
}
 //------------------------ Link Edit -------------------------
 if($action=="link_edit"){
     $qr = db_query("select * from links_links where id=$id");
     if(db_num($qr)){

        $data = db_fetch($qr) ;
        //-----------------------------
   $cat = intval($data['cat']);

      if($cat > 0){
$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from links_cats where id=$dir_data[cat]");

        $dir_content = "<a href='admin.php?action=cats&cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
        }

print "<p align=right><img src='images/link.gif'><a href='admin.php?action=cats&cat=0'>«·—∆Ì”Ì… </a> / $dir_content</p>";



    print "<center><form name=sender method=POST action='processing.php'>
    <input type=hidden name=action value='link_edit_ok'>
    <input type=hidden name=id value='$id'>
         <input type=hidden name=cat value='$cat'>


    <table width=80% class=grid>

    <tr>
    <td>«”„ «·„Êﬁ⁄ : </td>
    <td><input name='name' type='text' value='$data[name]'>
    </td></tr>

     <tr>
     <td> —«»ÿ «·„Êﬁ⁄ : </td>
     <td>
      <input type=\"text\" name=\"url\"  value='$data[url]' dir=ltr></td>

    </tr>

     <tr>
     <td> Ê’› : </td>
     <td>
      <textarea name=\"description\" cols=30 rows=5> $data[description]</textarea></td>

    </tr>

     <tr>
     <td> ‰„ÿ „Œ’’ :</td>
    <td>  <select name='class'>
    <option value='0'>»œÊ‰</option>
    ";
    $qr2=db_query("select * from links_classes");
    while($data2 = db_fetch($qr2)){
    if($data['class']==$data2['id']){$chk="selected";}else{$chk="";}

       print "<option value='$data2[id]' $chk >$data2[name]</option>";

            }
    print "</select></td></tr>

     <tr><td colspan=2 align=center><input type=submit value=' ⁄œÌ·'></td></form>
     <td align=left>
     <form action=admin.php method=post>
     <input type=hidden name=link_id value='$id'>
     <input type=hidden name=cat value='$cat'>
    <input type=hidden name=action value='link_move'>

     <input type=submit value='‰ﬁ· «·Ï ﬁ”„ «Œ—'>
     </form>
     </td>
     </tr>
    </table></center>";
    }else{
            print "<center>  €Ì— „ÊÃÊœ </center>";
            }
    }
 //-------------------------------------------------------------
        if($action == "cat_edit"){

               $data = mysql_fetch_array(mysql_query("select * from links_cats where id=$id"));

               print "<center>

                <table border=0 width=\"40%\"  style=\"border-collapse: collapse\" class=grid><tr>

                <form method=\"POST\" action=\"processing.php\">

                      <input type=hidden name=\"id\" value='$id'>
                       <input type=hidden name=\"cat\" value='$cat'>
                      <input type=hidden name=\"action\" value='edit_cat_ok'> ";


                  print "  <tr>
                                <td width=\"50\">
                <b>&#1575;&#1604;&#1575;&#1587;&#1605;</b></td><td width=\"223\">
                <input type=\"text\" name=\"name\" value='$data[name]' size=\"29\"></td>
                        </tr>

                        ";

                              print " <tr>
                                <td colspan=2>
                <center><input type=\"submit\" value=\" ⁄œÌ·\">
                        </td>
                        </tr>





                </table>

</form>    </center>\n";

                      }


// -------------- Blocks ----------------------------------
if ($action == "blocks"){


if_admin("blocks");

                       ?>
<center><table border="0" width="50%"  cellpadding="0" cellspacing="0" class="grid">
        <tr>
                <td height="0" >


                <form method="POST" action="processing.php">

                      <input type=hidden name="action" value='add_block'>



                        <tr>
                                <td width="70">
                <b>«·⁄‰Ê«‰</b></td><td >
                <input type="text" name="title" size="29"></td>
                        </tr>
                       <tr>
                                <td width="70">
                <b>«·„Õ ÊÏ</b></td><td width="223">
                  <textarea name='file' rows=10 cols=29 dir=ltr ></textarea></td>
                        </tr>

                               <tr> <td width="50">
                <b>«·„Êﬁ⁄</b></td>
                                <td width="223">
                <select size="1" name="pos">
                        <option value="r" selected>Ì„Ì‰</option>
                         <option value="c">Ê”ÿ</option>
                        <option value="l">Ì”«—</option>
                        </select> <input type="submit" value="&#1573;&#1590;&#1575;&#1601;&#1577;">
                        </td>
                        </tr>

                        <tr>
                                <td width="50">
                <b>«· — Ì»</b></td><td width="223">
                <input type="text" name="ord" value="1" size="2"></td>
                        </tr>




</table>
</form>    </center> <br>
<?

       $qr=db_query("select * from links_blocks order by pos DESC,ord ASC")   ;

       if (mysql_num_rows($qr)){
           print "<center><table border=\"0\" width=\"50%\" height=\"160\" cellpadding=\"0\" cellspacing=\"0\" class=\"grid\"> \n";


         while($data= db_fetch($qr)){
     print "            <tr>
                <td  width=\"306\">$data[title]</td>
                <td  width=\"306\">".str_replace("r","Ì„Ì‰",str_replace("l","Ì”«—",str_replace("c","Ê”ÿ",$data['pos'])))."</td>

                <td  width=\"254\">";

                if($data['active']){
                        print "<a href='processing.php?action=block_disable&id=$data[id]'> ⁄ÿÌ· </a>" ;
                        }else{
                        print "<a href='processing.php?action=block_enable&id=$data[id]'> ‰‘Ìÿ </a>" ;
                        }

                print "- <a href='admin.php?action=edit_block&id=$data[id]'> ⁄œÌ· </a>
                - <a href='processing.php?action=del_block&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">Õ–› </a></td>
        </tr>";

                 }

                print" </table>\n";
                }else{
                        print "<center> ·«  ÊÃœ «ﬁ”«„ </center>";
                        }

}
if($action == "edit_block"){

  $data=db_qr_fetch("select * from links_blocks where id='$id'");

 print " <center><table border=\"0\" width=\"50%\"  class=\"grid\" >
        <tr>
                <td height=\"0\" width=\"273\">

                <form method=\"POST\" action=\"processing.php\">

                      <input type=hidden name=\"action\" value='edit_block_ok'>
                       <input type=hidden name=\"id\" value='$id'>


                        <tr>
                                <td width=\"50\">
                <b>«·⁄‰Ê«‰</b></td><td width=\"223\">
                <input type=\"text\" name=\"title\" value='$data[title]' size=\"29\"></td>
                        </tr>
                       <tr>
                                <td width=\"50\">
                <b>«·„Õ ÊÏ</b></td><td width=\"223\">
                 <textarea name='file' rows=10 cols=50 dir=ltr >$data[file]</textarea></td>
                        </tr>";

                        if($data['pos']=="r"){
                                $option1 = "selected";
                                }elseif($data['pos']=="c"){
                                $option2 = "selected";
                                }else{
                                $option3="selected";
                                }

                             print"  <tr> <td width=\"50\">
                <b>«·„Êﬁ⁄</b></td>
                                <td width=\"223\">
                <select size=\"1\" name=\"pos\">
                        <option value=\"r\" $option1>Ì„Ì‰</option>
                        <option value=\"c\" $option2>Ê”ÿ</option>
                         <option value=\"l\" $option3>Ì”«—</option>
                        </select> <input type=\"submit\" value=\" ⁄œÌ·\">
                        </td>
                        </tr>

                              <tr>
                                <td width='50'>
                <b>«· — Ì»</b></td><td width='223'>
                <input type='text' name='ord' value='$data[ord]' size='2'></td>
                        </tr>




</table>
</form>    </center>\n";

        }
 //-------------------------- Votes ------------------------------------------
    if ($action == "votes" ||  $action=="vote_del" ||  $action == "vote_active"  || $action=="vote_add" ){

            if_admin("votes");

 if($action=="vote_add"){
        db_query("insert into links_votes_cats (title) values('$title')");
        }


//------------------------------
 if($action=="vote_del"){
         db_query("delete from links_votes_cats where id=$id");
         db_query("delete from links_votes where cat=$id");
         }

//---------------------------------
if($action == "vote_active"){
db_query("update links_votes_cats set active=0");
db_query("update links_votes_cats set active=1 where id=$id");
        }

         print "<center><p class=title > «· ’ÊÌ «  </p>
         <form action=admin.php method=post>
         <input type=hidden name=action value='vote_add'>
         <table width=50% class=grid><tr><td>
           <center><p class=title>«÷«›…  ’ÊÌ  ÃœÌœ </p></center>
         </td></tr>
         <td align=center><b>  «·⁄‰Ê«‰ :  </b><input name=title size=30> <input type=submit value=' ≈÷«›… '> </td></tr>

         </table></form><br>";

       $qr = db_query("select * from links_votes_cats");
print " <table class=grid width=70%>" ;
while($data = db_fetch($qr)){

     print "<tr><td width=70%>$data[title]  &nbsp;&nbsp;&nbsp;";
     if($data['active']){ print "[«› —«÷Ì]" ;}
     print "</td><td><a href='admin.php?action=vote_active&id=$data[id]'>  ⁄ÌÌ‰ «› —«÷Ì </a> - <a href='admin.php?action=vote_edit&cat=$data[id]'> ⁄œÌ·/ŒÌ«—« </a> - <a href='admin.php?action=vote_del&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">Õ–› </a> </td></tr>" ;

     }
    print "</table></center>";
      }
  //----------------------------------------------------------------------------
  if($action=="vote_edit" || $action=="vote2_add" || $action=="vote2_del" || $action=="vote2_edit_ok" ||$action=="vote_edit_ok" ){
  //--------------------------------
   if($action=="vote_edit_ok"){
      db_query("update links_votes_cats set title='$title' where id=$id");

         }
  //------------------------------------------
    if ($action=="vote2_add"){
            db_query("insert into links_votes (title,cat) values('$title','$cat')");
            }
  //---------------------------------------
  if($action=="vote2_del"){
          db_query("delete from links_votes where id=$id");
          }
  //-----------------------------------------
  if($action=="vote2_edit_ok"){
          db_query("update links_votes set title='$title' where id=$id");
          }
  //---------------------------------------

  $data=db_qr_fetch("select id,title from links_votes_cats where id=$cat");

   print "<center>
  <form action=admin.php mothod=post>
  <input type=hidden name=id value=$data[id]>
  <input type=hidden name=cat value=$cat>
  <input type=hidden name=action value='vote_edit_ok'>
  <table width=50% class=grid>
  <tr><td align=center>
  «·⁄‰Ê«‰ : <input type=text value='$data[title]' name=title size=30>
  <input type=submit value='  ⁄œÌ·  '></td></tr></table> </form>";

  print "
  <br>
  <form action=admin.php method=post>
  <input type=hidden name=action value='vote2_add'>
  <input type=hidden name=cat value='$cat'>
  <table width=50% class=grid><tr><td align=center>
  <p class=title> «÷«›… ŒÌ«—«  </p>
  «·⁄‰Ê«‰ : <input type=text name=title size=30>
  <input type=submit value=' «÷«›… '></td></tr></table><br>
  <table width=50% class=grid>";
  $qr=db_query("select * from links_votes where cat=$cat");
  while($data = db_fetch($qr)){
    print "<tr><td width=70%> $data[title] </td><td> <a href='admin.php?action=vote2_edit&id=$data[id]&cat=$cat'>  ⁄œÌ· </a>
    - <a href='admin.php?action=vote2_del&id=$data[id]&cat=$cat' onClick=\"return confirm('Are you sure you want to delete ?');\">Õ–› </a> </td>
    </tr>";

          }
       print "</table></center>";
          }
  //------------------------------------------------------
  if($action == "vote2_edit"){

  $data = db_qr_fetch("select * from links_votes where id=$id") ;
  print "<center>
  <form action=admin.php mothod=post>
  <input type=hidden name=id value=$id>
  <input type=hidden name=cat value=$cat>
  <input type=hidden name=action value='vote2_edit_ok'>
  <table width=50% class=grid>
  <tr><td align=center>
  «·⁄‰Ê«‰ : <input type=text value='$data[title]' name=title size=30>
  <input type=submit value='  ⁄œÌ· '></td></tr></table> </form></center>";
  }
 // ------------------------------- News ----------------------------------------
 if ($action == "news" or $action=="del_news" or $action=="edit_news_ok" or $action=="add_news"){

 if_admin("news");

if($action=="add_news"){
         mysql_query("insert into links_news(title,writer,content,details,date,img)values('$title','$writer','$content','$details',now(),'$img')");
        }
        //==========================================
    if ($action=="del_news"){
          mysql_query("delete from links_news where id='$id'");
            }
            //==============================================
            if ($action=="edit_news_ok"){
                mysql_query("update links_news set title='$title',writer='$writer',content='$content',details='$details',img='$img' where id='$id'");

                    }
                    //================================================
                       ?>
<center><table border="0" width="80%"   cellpadding="0" cellspacing="0" class="grid">
        <tr>
                <td height="0">
                <div align="center">
                <table border=0 width="97%"  style="border-collapse: collapse"><tr>

                <form name=sender method="POST" action="admin.php">

                      <input type=hidden name="action" value='add_news'>



                        <tr>
                                <td width="100">
                <b>«·⁄‰Ê«‰</b></td><td >
                <input type="text" name="title" size="50"></td>
                        </tr>
                       <tr>
                                <td width="100">
                <b>«·ﬂ« »</b></td><td width="223">
                <input type="text" name="writer" size="50"></td>
                        </tr>

                               <tr> <td width="100">
                <b>«·’Ê—…</b></td>
                                <td>
                                <table><tr><td>
                                <input type="text" name="img" size="50" dir=ltr>  </td><td> <a href="javascript:uploader('news');"><img src='images/file_up.gif' border=0 alt='—›⁄ ’Ê—… „‰ «·ÃÂ«“'></a>
                                 </td></tr></table>
                                 </td></tr>

                             <tr> <td width="100">
                <b>«·‰’ «·Œ«—ÃÌ</b></td>
                                <td width="223">
                                <textarea cols=50 rows=5 name='content'></textarea>       </td></tr>
                                          <tr> <td width="100">
                <b>«·„Õ ÊÏ</b></td>
                                <td width="223">
                                <textarea cols=50 rows=5 name='details'></textarea>

                 <input type="submit" value="&#1573;&#1590;&#1575;&#1601;&#1577;">
                        </td>
                        </tr>





                </table>
                </div>
                </td>
        </tr>
</table>
</form>    </center>
<?

       $qr=mysql_query("select * from links_news order by id DESC")   ;

       if (mysql_num_rows($qr)){
           print "<br><center><table border=0 width=\"80%\"   cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">";


         while($data= mysql_fetch_array($qr)){
     print "            <tr>
                <td  width=\"306\">$data[title]</td>

                <td  width=\"254\"><a href='admin.php?action=edit_news&id=$data[id]'> ⁄œÌ· </a> - <a href='admin.php?action=del_news&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">Õ–› </a></td>
        </tr>";

                 }

                print" </table>\n";
                }else{
                        print "<center> ·«  ÊÃœ «ﬁ”«„ </center>";
                        }

}
if($action == "edit_news"){

  $data=mysql_fetch_array(mysql_query("select * from links_news where id='$id'"));

      print " <center><table border=\"1\" width=\"70%\"  style=\"border-collapse: collapse\" bordercolor=\"#000000\">
        <tr>
                <td height=\"0\" bgcolor=\"#F8F8F8\">
                <div align=\"center\">
                <table border=0 width=\"97%\"  style=\"border-collapse: collapse\"><tr>

                <form method=\"POST\" action=\"admin.php\">

                    <input type=hidden name=\"action\" value='edit_news_ok'>
                       <input type=hidden name=\"id\" value='$id'>



                        <tr>
                                <td width=\"70\">
                <b>«·⁄‰Ê«‰</b></td><td >
                <input type=\"text\" name=\"title\" size=\"29\" value='$data[title]'></td>
                        </tr>
                       <tr>
                                <td width=\"70\">
                <b>«·ﬂ« »</b></td><td width=\"223\">
                <input type=\"text\" name=\"writer\" size=\"29\" value='$data[writer]'></td>
                        </tr>

                               <tr> <td width=\"100\">
                <b>«·’Ê—…</b></td>
                                <td width=\"223\">
                                <input type=\"text\" name=\"img\" size=\"29\" dir=ltr value='$data[img]'>
                                 </td></tr>


                             <tr> <td width=\"50\">
                <b>«·‰’ «·Œ«—ÃÌ</b></td>
                                <td width=\"223\">
                                <textarea cols=25 rows=10 name='content'>$data[content]</textarea>
                                </td></tr>
                                    <tr> <td width=\"50\">
                <b>«·„Õ ÊÏ</b></td>
                                <td width=\"223\">
                                <textarea cols=25 rows=10 name='details'>$data[details]</textarea>
                 <input type=\"submit\" value=\" ⁄œÌ·\">
                        </td>
                        </tr>





                </table>
                </div>
                </td>
        </tr>
</table>
</form>    </center>\n";

        }
// ------------------------------- pages ----------------------------------------
 if ($action == "pages" || $action=="del_pages" || $action=="edit_pages_ok" || $action=="add_pages" || $action=="page_enable" || $action=="page_disable"){

 if_admin("pages");

if($action=="page_enable"){
        db_query("update links_pages set active=1 where id=$id");
        }

if($action=="page_disable"){
        db_query("update links_pages set active=0 where id=$id");
        }

if($action=="add_pages"){
         mysql_query("insert into links_pages(title,content)values('$title','$content')");
        }
        //==========================================
    if ($action=="del_pages"){
          mysql_query("delete from links_pages where id='$id'");
            }
            //==============================================
            if ($action=="edit_pages_ok"){
                mysql_query("update links_pages set title='$title',content='$content' where id='$id'");

                    }
                    //================================================
                       ?>
<center><table border="0" width="70%"   cellpadding="0" cellspacing="0" class="grid">

                <form method="POST" action="admin.php">

                      <input type=hidden name="action" value='add_pages'>



                        <tr>
                                <td width="70">
                <b>«·⁄‰Ê«‰</b></td><td >
                <input type="text" name="title" size="50"></td>
                        </tr>



                             <tr> <td width="50">
                <b>«·„Õ ÊÏ</b></td>
                                <td width="223">
                                <textarea cols=50 rows=5 name='content'></textarea>

                 <input type="submit" value="&#1573;&#1590;&#1575;&#1601;&#1577;">
                        </td>
                        </tr>





                </table>

</form>    </center>
<?

       $qr=mysql_query("select * from links_pages order by id DESC")   ;
          print "<br><center><table border=0 width=\"70%\"   cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">";
       if (mysql_num_rows($qr)){



         while($data= mysql_fetch_array($qr)){
     print "            <tr>
                <td  width=\"306\">$data[title]</td>
                <td> <a target=_blank href='index.php?action=pages&id=$data[id]'> „‘«Âœ… «·’›Õ… </a> </td>
                <td  width=\"254\">" ;

                if($data['active']){
                        print "<a href='admin.php?action=page_disable&id=$data[id]'> ⁄ÿÌ· </a>" ;
                        }else{
                        print "<a href='admin.php?action=page_enable&id=$data[id]'> ‰‘Ìÿ </a>" ;
                        }

                print " - <a href='admin.php?action=edit_pages&id=$data[id]'> ⁄œÌ· </a> - <a href='admin.php?action=del_pages&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">Õ–› </a></td>
        </tr>";

                 }


                }else{
                        print "<tr><td width=100%><center> ·«  ÊÃœ «ﬁ”«„ </center></td></tr>";
                        }
                      print" </table>\n";
}
if($action == "edit_pages"){

  $data=mysql_fetch_array(mysql_query("select * from links_pages where id='$id'"));

      print " <center><table  width=\"70%\"  style=\"border-collapse: collapse\"  class=grid>

                <form method=\"POST\" action=\"admin.php\">

                    <input type=hidden name=\"action\" value='edit_pages_ok'>
                       <input type=hidden name=\"id\" value='$id'>



                        <tr>
                                <td width=\"70\">
                <b>«·⁄‰Ê«‰</b></td><td >
                <input type=\"text\" name=\"title\" size=\"29\" value='$data[title]'></td>
                        </tr>


                             <tr> <td width=\"50\">
                <b>«·„Õ ÊÏ</b></td>
                                <td width=\"223\">
                                <textarea cols=40 rows=10 name='content'>$data[content]</textarea>

                 <input type=\"submit\" value=\" ⁄œÌ·\">
                        </td>
                        </tr>






</table>
</form>    </center>\n";

        }
//-------------------- Permisions------------------------
if($action=="permisions"){

    if_admin();

    print " <center><form method=post action=admin.php>
           <input type=hidden value='$id' name='user_id'>
               <input type=hidden value='permisions_edit' name='action'>";


     $data =db_qr_fetch("select * from links_user where id=$id");


     if($data['perm_templates']){ $chk1 = "checked" ; }
      if($data['perm_adv']){ $chk2 = "checked" ; }
       if($data['perm_votes']){ $chk3 = "checked" ; }
        if($data['perm_blocks']){ $chk4 = "checked" ; }
         if($data['perm_news']){ $chk5 = "checked" ; }

     print "<table cellpadding=\"0\" border=0 cellspacing=\"0\" width=\"80%\" class=\"grid\">
     <tr> <td colspan=5 align=center><p class=title>  ’·«ÕÌ«  «·œŒÊ· ··√ﬁ”«„ </p></td></tr>
            <tr><td><input name=\"perm_templates\" type=\"checkbox\" value=1 $chk1>«·ﬁÊ«·»</td>
               <td><input name=\"perm_adv\" type=\"checkbox\" value=1 $chk2>«·≈⁄·«‰« </td>
                 <td><input name=\"perm_votes\" type=\"checkbox\" value=1 $chk3>«· ’ÊÌ « </td>
                  <td><input name=\"perm_blocks\" type=\"checkbox\" value=1 $chk4>«·ﬁÊ«∆„</td>
                 <td><input name=\"perm_news\" type=\"checkbox\" value=1 $chk5>«·√Œ»«—</td>

            </tr></table>";

          print "<center> <br><input type=submit value=' ⁄œÌ·'></form>" ;

        }
//---------------------------- Users ------------------------------------------
if ($action == "users" or $action=="edituserok" or $action=="adduserok" or $action=="deluser" || $action=="permisions_edit"){


if($action=="permisions_edit"){

if($perm_templates){$perm_templates=1;}else{$perm_templates=0;}
if($perm_adv){$perm_adv=1;}else{$perm_adv=0;}
if($perm_votes){$perm_votes=1;}else{$perm_votes=0;}
if($perm_blocks){$perm_blocks=1;}else{$perm_blocks=0;}
if($perm_news){$perm_news=1;}else{$perm_news=0;}

db_query("update links_user set perm_news=$perm_news,perm_templates=$perm_templates,perm_adv=$perm_adv,perm_votes=$perm_votes,perm_blocks=$perm_blocks where id=$user_id");

if($cat){
foreach ($cat as $value) {
       $prms .=  "$value," ;
     }
       $prms= substr($prms,0,strlen($prms)-1);
     db_query("update links_user set permisions='$prms' where id=$user_id") ;
    }else{
    db_query("update links_user set permisions='' where id=$user_id") ;
            }
  if($cat_video){
foreach ($cat_video as $value2) {
       $prms2 .=  "$value2," ;
     }
       $prms2= substr($prms2,0,strlen($prms2)-1);
     db_query("update links_user set permisions_videos='$prms2' where id=$user_id") ;
    }else{
         db_query("update links_user set permisions_videos='' where id=$user_id") ;
            }

           }

        //======================================================
        if ($action=="deluser" && $id){
mysql_query("delete from links_user where id='$id'");
        }
        //=============================================================
        if ($action == "adduserok"){
                if($username && $password){
                if(db_qr_num("select username from links_user where username='$username'")){
                        print "<center>  Œÿ√ .. «”„ «·„” Œœ„ «·–Ì ﬁ„  »≈œŒ«·Â „ÊÃÊœ „”»ﬁ« </center>";
                        }else{
        mysql_query("insert into links_user (username,password,email,group_id) values ('$username','$password','$email','$group_id')");
        }
        }else{
                print "<center>  Ì—ÃÏ «œŒ«· «”„ «·„” Œœ„ Ê ﬂ·„… «·„—Ê— </center>";
                }
        }
        //========================================================================
        if ($action == "edituserok"){
                if ($password){
                $ifeditpassword = ", password='$password'" ;
                }


        mysql_query("update links_user set username='$username'  , email='$email' ,group_id='$group_id' $ifeditpassword where id=$id");

        if (mysql_affected_rows()){
                print "<center>   „  ⁄œÌ· «·„” Œœ„ »‰Ã«Õ </center>";
        }
        }

        if ($HTTP_COOKIE_VARS['links_group_id'] == 1){
//print "<center> <a href='admin.php?action=adduser'> ≈÷«›… „” Œœ„ </a><br></center><br>";
//--------------------- Add User Form -------------------------------------------------------
   ?>
   <br>
   <center>

<FORM METHOD="post" ACTION=<? print $PHP_SELF ; ?>>

 <TABLE width="40%" class=grid>
    <TR>
   <td colspan=2 align=center><span class=title> «÷«›… „” Œœ„ </span></td></tr>
   <tr>
<INPUT TYPE="hidden" NAME="action"  value="adduserok" >

   <TD width="150"><font color="#006699"><b>≈”„ «·„” Œœ„: </b></font> </TD>
   <TD ><INPUT TYPE="text" NAME="username" size="32"  </TD>
  </TR>
    <TR>
   <TD width="150"><font color="#006699"><b>ﬂ·„… «·„—Ê— : </b></font> </TD>
   <TD ><INPUT TYPE="password" NAME="password" size="32" > </TD>
  </TR>
   <TR>
   <TD width="150"><font color="#006699"><b>«·»—Ìœ «·≈·ﬂ —Ê‰Ì : </b></font> </TD>
   <TD ><INPUT TYPE="text" NAME="email" size="32" > </TD>
  </TR>

   <TR>
   <TD width="150"><font color="#006699"><b>«·— »…: </b></font> </TD>
   <TD >
   <?

print "  <p><select size=\"1\" name=group_id>\n
        <option value='1' > „œÌ— </option>
  <option value='2' >„‘—› </option>" ;


 print "  </select>";

    ?>
   </TD>
  </TR>


  <TR>
   <TD COLSPAN="2" >
   <p align="center"><INPUT TYPE="submit" name="useraddbutton" VALUE="≈÷«›… «·„” Œœ„"></TD>
  </TR>
 </TABLE>
</FORM>
</center><br><br>
<?


     print "<center>«·„” Œœ„Ì‰</center>";
       $result=mysql_query("select * from links_user ");


  print " <center> <table cellpadding=\"0\" border=0 cellspacing=\"0\" width=\"80%\" class=\"grid\">

        <tr>
             <td height=\"18\" width=\"134\" valign=\"top\" align=\"center\">≈”„ «·„” Œœ„</td>
                <td height=\"18\" width=\"240\" valign=\"top\">
                <p align=\"center\">«·»—Ìœ «·≈·ﬂ —Ê‰Ì</td>
                <td height=\"18\" width=\"105\" valign=\"top\">
                <p align=\"center\">«·— »…</td>
                <td height=\"18\" width=\"193\" valign=\"top\" colspan=2>
                <p align=\"center\">«·ŒÌ«—« </td>
        </tr>";

      while($data = mysql_fetch_array($result)){


        if ($data['group_id']==1){$groupname="„œÌ—";
             $permision_link="";
      }elseif($data['group_id']==2){$groupname="„‘—›";
       $permision_link="<a href='admin.php?action=permisions&id=$data[id]'>«· ’«—ÌÕ</a>";

      }


        print "<tr>
                <td  width=\"134\" >
                <p align=\"center\">$data[username]</p></td>
                <td  width=\"240\" >
                <p align=\"center\">$data[email]</p></td>
                <td  width=\"105\"><p align=\"center\">$groupname</p></td>
                 <td  width=\"105\"><p align=\"center\">$permision_link</p></td>
                <td  width=\"193\"><p align=\"center\">
                 <a href='admin.php?action=edituser&id=$data[id]'>  ⁄œÌ· </a> ";
        if ($data['id'] !="1"){
                print "- <a href='admin.php?action=deluser&id=$data[id]' onClick=\"return confirm('Â· √‰  „ √ﬂœ ?');\"> Õ–› </a>";
        }
                print " </p>
                </td>
        </tr>";
          }

print "</table></center>\n";




        }else{

                print "<center>’·«ÕÌ« ﬂ ·«  ”„Õ ≈·« » ⁄œÌ· Õ”«»ﬂ «·‘Œ’Ì ›ﬁÿ <br> <a href='admin.php?action=edituser'> · ⁄œÌ· Õ”«»ﬂ ≈÷€ÿ Â‰« </a></center>";
        }
        }
        //================================================================



 //===========================================================
        if ($action=="edituser"){

if($HTTP_COOKIE_VARS['links_group_id']!=1){
        $id=$HTTP_COOKIE_VARS['links_id'];

}

$result=mysql_query("select * from links_user where id=$id") ;
if (!mysql_num_rows($result)){
print "<center> √ﬂœ „‰ «·„·›</center>" ;

}else{
$data = mysql_fetch_object($result) ;
?>
<center>
<FORM METHOD="post" ACTION=<? print $PHP_SELF ; ?>>

 <TABLE BORDER="1" width="696">
    <TR>

    <INPUT TYPE="hidden" NAME="id" " value="<? print $data->id ; ?>" >
<INPUT TYPE="hidden" NAME="action"  value="edituserok" >

   <TD width="100"><font color="#006699"><b>≈”„ «·„” Œœ„: </b></font> </TD>
   <TD width="614"><INPUT TYPE="text" NAME="username" size="32" value="<? print $data->username ; ?>" > </TD>
  </TR>
    <TR>
   <TD width="100"><font color="#006699"><b>ﬂ·„… «·„—Ê— : </b></font> </TD>
   <TD width="614"><INPUT TYPE="password" NAME="password" size="32"> * √ —ﬂÂ ›«—€« ·⁄œ„ «· €ÌÌ— </TD>
  </TR>
   <TR>
   <TD width="100"><font color="#006699"><b>«·»—Ìœ «·≈·ﬂ —Ê‰Ì : </b></font> </TD>
   <TD width="614"><INPUT TYPE="text" NAME="email" size="32" value="<? print $data->email ; ?>" > </TD>
  </TR>
  <?
  if($HTTP_COOKIE_VARS['links_group_id'] != 1){
          print "<input type='hidden' name='group_id' value='2'>";
  }else {?>
   <TR>
   <TD width="100"><font color="#006699"><b>«·— »…: </b></font> </TD>
   <TD width="614">
   <?

if ($data->group_id == 1){$ifselected1 = "selected" ; }else{$ifselected2 = "selected";}

print "  <p><select size=\"1\" name=group_id>\n
        <option value='1' $ifselected1> „œÌ— </option>
  <option value='2' $ifselected2>„‘—› </option>" ;


 print "  </select>";
  }
    ?>
   </TD>
  </TR>


  <TR>
   <TD COLSPAN="2" width="685">
   <p align="center"><INPUT TYPE="submit" name="usereditbutton" VALUE=" ⁄œÌ·"></TD>
  </TR>
 </TABLE>
</FORM>
</center>

<?
}

        }


 //-----------------------------------------------------------------
        if ($action == "banners"){
        print "<center><table width=50% class=grid><tr><td align=center><a href='admin.php?action=adv'> ‰Ÿ«„ «·«⁄·«‰«  »Ê«”ÿ… «·ﬂÊœ </a><br><br>
        <a href='admin.php?action=adv2'> ‰Ÿ«„ «·«⁄·«‰«   «·⁄«„ </a></td></tr></table></center>";
                }
  //---------------- Adv 2 -------------------------------------
   if($action =="adv2" or $action =="adv2_edit_ok" or $action =="adv2_del" or $action =="adv2_add_ok"){

   if_admin("adv");
  print "<center>  <a href='admin.php?action=adv2_add'> «÷«›… «⁄·«‰ </a> </center> <br>" ;

    if($action =="adv2_add_ok"){
      db_query("insert into  links_banners (title,url,img,ord,type,date,menu_id,menu_pos) values ('$title','$url','$img','$ord','$type',now(),'$menu_id','$menu_pos')");

          }

  if($action =="adv2_edit_ok"){

      mysql_query("update links_banners set title='$title',url='$url',img='$img',ord='$ord',type='$type',menu_id='$menu_id',menu_pos='$menu_pos' where id='$id'");

          }

          if($action =="adv2_del"){

      mysql_query("delete from links_banners where id=$id");

          }

 $qr= mysql_query("select * from links_banners order by type , ord");
    print "
  <center>
  <table width=70% border=1>
  <tr><td>«·⁄‰Ê«‰</td>

  <td>«· — Ì»</td>
  <td>«·‰Ê⁄</td>
  <td>«·ﬁ«∆„…</td>
  <td>„—«  «·ŸÂÊ—</td>
   <td>«·“Ì«—« </td>

  <td> ⁄œÌ·</td>
  <td>Õ–›</td>
  </tr>
  ";
  while($data=mysql_fetch_array($qr)){

  print "<tr><td>$data[title]</td>

   <td>$data[ord]</td>
   <td>$data[type]</td>
   <td> ".str_replace("r","Ì„Ì‰",str_replace("l","Ì”«—",str_replace("c","Ê”ÿ",$data['menu_pos'])))."</td>
     <td>$data[views]</td>
       <td>$data[clicks]</td>
    <td><a href='admin.php?action=adv2_edit&id=$data[id]'> ⁄œÌ·</a></td>
    <td><a href='admin.php?action=adv2_del&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">Õ–› </a></td>
  </tr>" ;

      }
       print "</table></center>\n";
          }

   //----------------------------------------------------------
   if ($action == "adv2_edit"){
        $data=mysql_fetch_array(mysql_query("select * from links_banners where id='$id'"));

          print "  <center><table width=\"40%\" class=grid>
        <tr>

                <form name=sender method=\"POST\" action=\"admin.php\">
                 <input type='hidden' value='adv2_edit_ok' name='action'>
                  <input type='hidden' value='$id' name='id'>

                         <td height=\"13\" width=\"131\">
                       «·«”„<td height=\"13\" width=\"308\">
                <input type=\"text\" name=\"title\" value='$data[title]' size=\"38\"></td>
        </tr>
        <tr>
                <td height=\"35\" width=\"131\">«·⁄‰Ê«‰</td>
                <td height=\"35\" width=\"308\">
                <input type=\"text\" name=\"url\" value='$data[url]' size=\"38\"></td>
        </tr>

         <tr>
                <td height=\"35\" width=\"131\">«·’Ê—…</td>
                <td height=\"35\" width=\"308\">
                <input type=\"text\" name=\"img\" value='$data[img]' size=\"38\"></td>
        </tr>

        <tr>
                <td height=\"45\" width=\"131\">&#1575;&#1604;&#1606;&#1608;&#1593;</td>
                <td height=\"45\" width=\"308\"><select name=\"type\" size=\"1\">
             ";
             if($data['type']=="header"){
                     $opt1 = "selected" ; }elseif($data['type']=="footer"){
                             $opt2="selected" ; }elseif($data['type']=="open"){ $opt3="selected" ;}
                             elseif($data['type']=="close"){ $opt4="selected" ;}else{$opt5="selected" ; }

                print "
                <option value=\"header\" $opt1>&#1576;&#1606;&#1585; &#1607;&#1610;&#1583;&#1585;</option>
                <option value=\"footer\" $opt2>&#1576;&#1606;&#1585; &#1601;&#1608;&#1578;&#1585;</option>
                   <option value=\"open\" $opt3>»«‰— › Õ…</option>
                 <option value=\"close\" $opt4>»«‰— ﬁ›·…</option>
                 <option value=\"menu\" $opt5>«⁄·«‰ ﬁ«∆„…</option>

                </select></td>\n";

       print " </tr>
        <tr>
                <td height=\"43\" width=\"131\">«÷«›… »⁄œ ﬁ«∆„… —ﬁ„ : </td>
                <td height=\"43\" width=\"308\">
                <input type=\"text\" value='$data[menu_id]' name=\"menu_id\" value='0' size=\"4\">  ›Ì
                <select name=\"menu_pos\" size=\"1\">
             ";

             if($data['menu_pos']=="r"){$opt11 = "selected" ; }elseif($data['menu_pos']=="c"){$opt21="selected" ; }else{ $opt31="selected" ;}

                print "
                <option value=\"r\" $opt11>Ì„Ì‰</option>
                <option value=\"c\" $opt21>Ê”ÿ</option>
                 <option value=\"l\" $opt31>Ì”«—</option>

                </select> <font color=#FF0000> *  ›Ì Õ«·… «⁄·«‰ «·ﬁ«∆„… ›ﬁÿ </font></td>

                </tr>

                <tr>
                <td height=\"43\" width=\"131\">&#1575;&#1604;&#1578;&#1585;&#1578;&#1610;&#1576;</td>
                <td height=\"43\" width=\"308\"><input type=\"text\" value='$data[ord]' name=\"ord\" value='0' size=\"4\"></td>
                </tr>
        <tr>
                <td height=\"21\" width=\"444\" colspan=\"2\">
                <p align=\"center\">
                <input type=\"submit\" value=\" ⁄œÌ·\" name=\"B1\"></td>
        </tr>
</table>
        </form></center>\n";

           }

           if ($action == "adv2_add"){

        print "  <center><table  width=\"40%\" class=grid>
        <tr>

                <form method=\"POST\" action=\"admin.php\">
                 <input type='hidden' value='adv2_add_ok' name='action'>

                   <td height=\"13\" width=\"131\">
                      «·«”„<td height=\"13\" width=\"308\">
                <input type=\"text\" name=\"title\" size=\"38\"></td>
        </tr>
         <tr>
                <td height=\"35\" width=\"131\">«·⁄‰Ê«‰</td>
                <td height=\"35\" width=\"308\">
                <input type=\"text\" name=\"url\"  dir=ltr value='http://' size=\"38\"></td>
        </tr>
        <tr>
                <td height=\"35\" width=\"131\">«·’Ê—…</td>
                <td height=\"35\" width=\"308\">
                <input type=\"text\" name=\"img\" dir=ltr  size=\"38\"></td>
        </tr>

        <tr>
                <td height=\"45\" width=\"131\">&#1575;&#1604;&#1606;&#1608;&#1593;</td>
                <td height=\"45\" width=\"308\"><select name=\"type\" size=\"1\">
             ";
                print "
                <option value=\"header\" selected>&#1576;&#1606;&#1585; &#1607;&#1610;&#1583;&#1585;</option>
                <option value=\"footer\">&#1576;&#1606;&#1585; &#1601;&#1608;&#1578;&#1585;</option>

                   <option value=\"open\" >»«‰— › Õ…</option>
                 <option value=\"close\" >»«‰— ﬁ›·…</option>
                 <option value=\"menu\" >«⁄·«‰ ﬁ«∆„…</option>

                </select></td>\n";

       print " </tr>
        <tr>
                <td height=\"43\" width=\"131\">«÷«›… »⁄œ ﬁ«∆„… —ﬁ„ : </td>
                <td height=\"43\" width=\"308\">
                <input type=\"text\"  name=\"menu_id\" value=0 size=\"4\">  ›Ì
                <select name=\"menu_pos\" size=\"1\">
             ";



                print "
                <option value=\"r\" >Ì„Ì‰</option>
                <option value=\"c\" >Ê”ÿ</option>
                 <option value=\"l\" >Ì”«—</option>

                </select> <font color=#FF0000> *  ›Ì Õ«·… «⁄·«‰ «·ﬁ«∆„… ›ﬁÿ </font></td>

                </tr>
               ";
       print "
                <tr>
                <td height=\"43\" width=\"131\">&#1575;&#1604;&#1578;&#1585;&#1578;&#1610;&#1576;</td>
                <td height=\"43\" width=\"308\"><input type=\"text\" name=\"ord\" value='0' size=\"4\"></td>
                </tr>
        <tr>
                <td height=\"21\" width=\"444\" colspan=\"2\">
                <p align=\"center\">
                <input type=\"submit\" value=\"«÷«›…\" name=\"B1\"></td>
        </tr>
</table>
        </form></center>\n";

           }
 //=========== Adv ==================================

  if($action =="adv" or $action =="adv_edit"){

  if($action =="adv_edit"){
      mysql_query("update links_adv set content='$content' where type='$type'");

          }

  $qr = mysql_query("select * from links_adv");


    while($data=mysql_fetch_array($qr)){
print "
  <center>
          <span class=title>$data[type] </span>  <br>
  <form method=\"POST\" action=\"admin.php\">
  <input type='hidden' name='action' value='adv_edit'>
  <input type='hidden' name='type' value='$data[type]'>
        <p><textarea dir=ltr rows=\"8\" name=\"content\" cols=\"58\">$data[content]
        </textarea><br><input type=\"submit\" value=\" ⁄œÌ·\" name=\"B1\"></p>
</form><hr width=60%></center>\n";
     }

          }
//--------------------- Templates ----------------------------------

  if($action =="templates" or $action =="templates_edit"){

  if($action =="templates_edit"){
      mysql_query("update links_templates set content='$content' where name='$name'");

          }

  $qr = mysql_query("select * from links_templates order by id ");


    while($data=mysql_fetch_array($qr)){
print "
  <center>
          <span class=title>$data[title] </span>  <br>
  <form method=\"POST\" action=\"admin.php\">
  <input type='hidden' name='action' value='templates_edit'>
  <input type='hidden' name='name' value='$data[name]'>
        <p><textarea dir=ltr rows=\"8\" name=\"content\" cols=\"58\">$data[content]
        </textarea><br><input type=\"submit\" value=\" ⁄œÌ·\" name=\"B1\"></p>
</form><hr width=60%></center>\n";
     }

          }
//----------------------- Settings --------------------------------
 if($action == "settings" || $action=="settings_edit"){
 if_admin();

 if($action=="settings_edit"){
 db_query("update links_settings set value='$stng_sitename' where name='sitename'");
 db_query("update links_settings set value='$stng_section_name' where name='section_name'");
 db_query("update links_settings set value='$stng_html_dir' where name='html_dir'");
 db_query("update links_settings set value='$stng_header_keywords' where name='header_keywords'");
 db_query("update links_settings set value='$stng_rows_limit' where name='rows_limit'");
  db_query("update links_settings set value='$stng_links_add_limit' where name='links_add_limit'");
         }

 load_settings();

 print "<center>
 <p align=center class=title>  «·≈⁄œ«œ«  </p>
 <form action=admin.php method=post>
 <input type=hidden name=action value='settings_edit'>
 <table width=70% class=grid>
 <tr><td>  «”„ «·„Êﬁ⁄ : </td><td><input type=text name=stng_sitename size=30 value='$settings[sitename]'></td></tr>
 <tr><td>  «”„ «·ﬁ”„ : </td><td><input type=text name=stng_section_name size=30 value='$settings[section_name]'></td></tr>
 <tr><td> « Ã«Â «·’›Õ… : </td><td><select name=stng_html_dir>" ;
 if($settings['html_dir'] == "rtl"){$chk1 = "selected" ; $chk2=""; }else{ $chk2 = "selected" ; $chk1="";}
 print "<option value='rtl' $chk1>„‰ «·Ì„‰ «·Ï «·Ì”«—</option>
 <option value='ltr' $chk2>„‰ «·Ì”«— «·Ï «·Ì„Ì‰</option>
 </select>
 </td></tr>
  <tr><td>  ﬂ·„«  „”«⁄œ… : </td><td><input type=text name=stng_header_keywords size=30 value='$settings[header_keywords]'></td></tr>

 <tr><td colspan=2 height=1 background='images/dot.gif'></td></tr>
  <tr><td>  ⁄œœ «·ÕﬁÊ· ›Ì «·«÷«›… : </td><td><input type=text name=stng_links_add_limit size=5 value='$settings[links_add_limit]'></td></tr>

  <tr><td>  ⁄œœ «·√⁄„œ… : </td><td><input type=text name=stng_rows_limit size=5 value='$settings[rows_limit]'></td></tr>



 <tr><td colspan=2 align=center><input type=submit value='  ⁄œÌ· '></td></tr>
 </table></center>" ;

         }

//-----------------------------------------------------------------------------

?>
</td></tr></table>
<?

}else{
    ?>
<html dir=rtl>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
<meta http-equiv="Content-Language" content="ar-sa" />
<title> <? print $sitename ;?> - ·ÊÕ… «· Õﬂ„ </title>
</head>
<body>
<?

open_table(" ”ÃÌ· œŒÊ·");
?>
<center>
<form action="<? print $PHP_SELF ; ?>" method="post"">
                 <table><tr><td><img src='images/users.gif'></td><td>

                <table dir=rtl cellpadding="0" cellspacing="3" border="0">
                <tr>
                        <td class="smallfont">«”„ «·„” Œœ„</td>
                        <td><input type="text" class="button" name="username"  size="10" tabindex="1" ></td>
                        <td class="smallfont" colspan="2" nowrap="nowrap"></td>
                </tr>
                <tr>
                        <td class="smallfont">ﬂ·„… «·„—Ê—</td>
                        <td><input type="password"  name="password" size="10" tabindex="2" /></td>
                        <td>
                        <input type="submit" class="button" value=" ”ÃÌ· «·œŒÊ·" tabindex="4" accesskey="s" /></td>
                </tr>

</td>
</tr>
                </table>
                <input type="hidden" name="s" value="" />
                <input type="hidden" name="action" value="login" />
                </td></tr></table>
                </form> </center> <?



close_table();
open_table();
print "<center>  Ã„Ì⁄ ÕﬁÊﬁ «·»—„Ã… „Õ›ÊŸ… <a href='http://allomani.com' target='_blank'> ··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ… </a>  © 2006</center>";
close_table();

if(file_exists("demo_msg.php")){
include_once("demo_msg.php");
}
}