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
include "global.php";



site_header();



print "<table dir=rtl border=\"0\" width=\"100%\"  style=\"border-collapse: collapse\">

         <tr>";

       //----------------------- Right Content --------------------------------------------
        $xqr=db_query("select * from links_blocks where pos='r' and active=1 order by ord");
        if(db_num($xqr)){
        print "<td width=17% valign=\"top\">
        <center><table hieght=100% width=100%>" ;



        $adv_c = 1 ;
         while($xdata = db_fetch($xqr)){

        print "<tr>
                <td  width=\"100%\" valign=\"top\">";
                open_block($xdata['title']);


                 run_php($xdata['file']);


                close_block();

                print "</td>
        </tr>";

         //---------------------------------------------------
        $adv_menu_qr = db_query("select * from links_banners where type='menu' and menu_id=$adv_c and menu_pos='r' order by ord");

        if(db_num($adv_menu_qr)){
                $data = db_fetch($adv_menu_qr) ;
                db_query("update links_banners set views=views+1 where id=$data[id]");
                print "<tr>
                <td  width=\"100%\" valign=\"top\">";
              // open_block();
             print "<br><center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a></center><br>";
             // close_block();
                print "</td>
        </tr>";
               }
            ++$adv_c ;

           }
     //----------------------------------------------------
print "</table></center></td>";
}
   //------------------------END RIGHT MENUS -------------


print "<td  valign=\"top\">";

//------------------- Advertise -----------------------------------------
$data=mysql_fetch_array(mysql_query("select * from links_adv where type='header'"));
run_php($data['content']);
//---------------------  Banners ----------------------------
$qr = db_query("select * from links_banners where type='header' order by ord");
while($data = db_fetch($qr)){
db_query("update links_banners set views=views+1 where id=$data[id]");
print "<center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a><br></center>";
        }
 print "<br>";


if (!$action){




    $data= db_qr_fetch("select * from links_banners where type='open'");

    if ($data['url']){
   print "<script>
        msgwindow=window.open(\"$data[url]\",\"displaywindow\",\"toolbar=yes,scrollbars=yes,resizable=yes,width=650,height=300,top=200,left=200\")
        </script>\n";
            }

            $data= db_qr_fetch("select * from links_banners where type='close'");

    if ($data['url']){
   print "<script>
   function pop_close(){
        msgwindow=window.open(\"$data[url]\",\"displaywindow\",\"toolbar=yes,scrollbars=yes,resizable=yes,width=650,height=300,top=200,left=200\")
        }
        </script>\n";

            }

      $yqr=db_query("select * from links_blocks where pos='c' and active=1 order by ord");
  $adv_c = 1 ;
         while($ydata = db_fetch($yqr)){


                open_table($ydata['title']);


           run_php($ydata['file']);


                close_table();
                    }
 }
//-------------------------- Add URL ---------------------------------
if($action=="add_url"){
open_table(" ≈÷«›… „Êﬁ⁄ ");
 if($name && $url){
  $description =  htmlspecialchars(trim($description));
 $name=htmlspecialchars($name) ;
 $url=htmlspecialchars($url) ;
 $cat = intval($cat);
 
db_query("insert into links_links (name,url,description,date,cat,active) values('$name','$url','$description',now(),'$cat','0');");
   print "<center>‘ﬂ—« ·ﬂ , ”Ê› ‰ﬁÊ„ »„—«Ã⁄… „Êﬁ⁄ﬂ Ê «÷«› Â ›Ì √ﬁ—» Êﬁ </center>";
         }else{
 print "<form action=index.php method=post><input type=hidden value='add_url' name='action'>
  <table >
 <tr><td><b> ≈”„ «·„Êﬁ⁄ </b></td><td><input name='name' type=text size=35></td></tr>
  <tr><td ><b> —«»ÿ «·„Êﬁ⁄ </b></td><td><input name='url' type=text size=35 dir=ltr value='http://'></td></tr>
   <tr><td ><b> Ê’› «·„Êﬁ⁄ </b></td><td><textarea name='description'rows=5 cols=40></textarea></td></tr>
  <tr><td ><b> «· ’‰Ì› </b></td><td><select name=cat>";
 $qr=db_query("select * from links_cats where cat=0");
while($data = db_fetch($qr)){
       print "<option value='$data[id]'>$data[name]</option>" ;
       $qr2 = db_query("select * from links_cats where cat='$data[id]'");
      while($data2 = db_fetch($qr2)){
      print "<option value='$data2[id]'>$data[name] > $data2[name] </option>" ;

        $qr3 = db_query("select * from links_cats where cat='$data2[id]'");
      while($data3 = db_fetch($qr3)){
      print "<option value='$data3[id]'>$data[name] > $data2[name] > $data3[name] </option>" ;
      }
              }
        }
  print "</select></td></tr>


   <tr><td colspan=2 align=center><input type=submit value=' «—”«· '></td></tr></table></form>";
       }
       close_table();
        }
//--------------------------- Browse --------------------------------------
if($action=="browse"){


   if(!$cat){$cat=0;}

    if($cat > 0){
$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from links_cats where id=$dir_data[cat]");
        if($dir_content){
        $dir_content = "<a href='index.php?action=browse&cat=$dir_data[id]'>$dir_data[name]</a> <img src='images/arrw.gif'> ". $dir_content  ;
        }else{
        $dir_content = "$dir_data[name]" ;
                }
        }
        }

print "<p align=right><img src='images/link.gif'><a href='index.php'>«·—∆Ì”Ì… </a> <img src='images/arrw.gif'> $dir_content</p>";

 $qr_title = db_query("select name from links_cats where id='$cat'");
 if(db_num($qr_title)){
 $data_title = db_fetch($qr_title);
 $qr_cats = db_query("select * from links_cats where cat='$cat' order by $config_cats_order");
 //---------------- Cats -------------
 if(db_num($qr_cats)){
open_table($data_title['name']);
$c = 1 ;
print "<table width=100% class=browse dir=rtl><tr>" ;
$td_width =  100 / $settings['rows_limit'] ;
while($data_cats = db_fetch($qr_cats)){
 $links_cnt = db_qr_fetch("select count(id) as count from links_links where cat='$data_cats[id]' and active=1");
 $links_count  =  $links_cnt['count'] ;



 print "<td width='$td_width%'>";
 run_php(get_template("browse_cats"));
 print "</td>";

  if($c >= $settings['rows_limit']){
      print "</tr><tr>";
      $c=0;
         }
   $c++;

        }
   print "</tr></table>";
        close_table();
        }
//--------------- Links ----------------

    if($orderby == "name") {
    $orderbysql = "binary name" ;
    }elseif($orderby == "hits") {
    $orderbysql = "hits" ;
    }elseif($orderby == "votes") {
    $orderbysql = "(votes / votes_total)" ;
    }else{
    $orderbysql = "id" ;
    }

    if($orderby2 !="asc" && $orderby2 !="desc"){
    $orderby2 = "desc" ;
            }

   $qr_links = db_query("select * from links_links where cat='$cat' and active=1 order by $orderbysql $orderby2");


   if(db_num($qr_links)){
    while($data=db_fetch($qr_links)){
     if($data['class'] == 0){
             $links_arr[] = "$data[id]" ;
            }else{

     $data2 = db_qr_fetch("select special from links_classes where id='$data[class]'");
     if($data2['special']==1){
      $links_arr_sp[] = "$data[id]" ;
           }else{
            $links_arr[] = $data['id'] ;
                   }


                    }
           }
        }


   if(count($links_arr) || count($links_arr_sp)){


    if(db_num($qr_cats)){$links_title = "" ;}else{$links_title = $data_title['name'];}

    run_php(get_template("links_orderby"));

        open_table($links_title);

       $c = 1 ;
print "<table width=100% class=browse dir=rtl><tr>" ;
$td_width =  100 / $settings['rows_limit'] ;

   if(count($links_arr_sp)){
       foreach($links_arr_sp as $data_id){
       if(trim($data_id)){
     $data_links = db_qr_fetch("select * from links_links where id='$data_id'");

         $votes=$data_links['votes'];
       $votes_total=$data_links['votes_total'];
       if($votes && $votes_total){
        $link_votes = $votes/$votes_total;
       }else{
       $link_votes = 0 ;
       }


     print "<td width='$td_width%'>" ;

   run_php(get_template("browse_links"));


     print " </td>";

 if($c >= $settings['rows_limit']){
      print "</tr><tr>";
      $c=0;
         }
         $c++;
                }
  }}

   if(count($links_arr)){
       foreach($links_arr as $data_id2){
         if(trim($data_id2)){
     $data_links = db_qr_fetch("select * from links_links where id='$data_id2'");



        $votes=$data_links['votes'];
       $votes_total=$data_links['votes_total'];
       if($votes && $votes_total){
       $link_votes = $votes/$votes_total;
       }else{
       $link_votes = 0 ;
       }

     print "<td width='$td_width%'>" ;

   run_php(get_template("browse_links"));


     print " </td>";

 if($c >= $settings['rows_limit']){
      print "</tr><tr>";
      $c=0;
         }
         $c++;
                }
        }}

         print "</tr></table>";
      close_table();
      }
//-------------- Confirm -------------------
if(!count($links_arr) && !count($links_arr_sp) && !db_num($qr_cats)){
        open_table($data_title['name']);
        print "<center>  Â–« «· ’‰Ì› ›«—€ </center>";
        close_table();
        }

        }else{
                open_table();
                print "<center>  —«»ÿ Œ«ÿÌ¡ </center>";
                close_table();
                }
}

 //--------------------------------- Search ---------------------------
 if($action=="search"){
 open_table("‰ «∆Ã «·»ÕÀ");
   if($keyword){
  $keyword = trim($keyword);
  $qr_links = db_query("select * from links_links where active=1 and (description like '%$keyword%' or name like '%$keyword%') order by binary name asc");
  if(db_num($qr_links)){
  $c = 1;
  print "<table width=100% class=browse dir=rtl><tr>";
  $td_width =  100 / $settings['rows_limit'] ;
   while($data_links = db_fetch($qr_links)){



        $votes=$data_links['votes'];
       $votes_total=$data_links['votes_total'];
       if($votes && $votes_total){
       $link_votes = $votes/$votes_total;
       }else{
       $link_votes = 0 ;
       }

     print "<td width='$td_width%'>" ;

   run_php(get_template("browse_links"));


     print " </td>";

 if($c >= $settings['rows_limit']){
      print "</tr><tr>";
      $c=0;
         }
         $c++;


           }
      print "</tr></table>";
      //-----------------------------------------------------

          }else{
        print "<center>  ⁄›Ê« , ·«  ÊÃœ ‰ «∆Ã ·„«  »ÕÀ ⁄‰Â </center>";
        }
       }else{
               print "<center> Ì—ÃÏ ﬂ «»… ﬂ·„… ··»ÕÀ ⁄‰Â« </center>" ;
               }
   close_table();
         }
  //-------------------------------------------------------------------
  if($action=="contactus"){
          open_table("«·« ’«· »‰«");
         print get_template("contactus");
          close_table();
          }
 // --------------------------- Votes ---------------------------------
  if($action =="votes" || $action == "vote_add"){
          if ($action=="vote_add")
          {
                  mysql_query("update links_votes set cnt=cnt+1 where id='$vote_id'");
          }

          $data_title = mysql_fetch_array(mysql_query("select * from links_votes_cats  where active=1"));
          open_table("$data_title[title]");


          $sql = "select * from links_votes where cat=$data_title[id]" ;
          $qr_stat=mysql_query($sql);


if (mysql_num_rows($qr_stat)){
while($data_stat=mysql_fetch_array($qr_stat)){
$total = $total + $data_stat['cnt'];
}

    if($total){
         print "<br>";

  $l_size = getimagesize("images/leftbar.gif");
    $m_size = getimagesize("images/mainbar.gif");
    $r_size = getimagesize("images/rightbar.gif");

$qr_stat=mysql_query($sql);
 echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" align=\"center\">";
while($data_stat=mysql_fetch_array($qr_stat)){

    $rs[0] = $data_stat['cnt'];
    $rs[1] =  substr(100 * $data_stat['cnt'] / $total, 0, 5);
    $title = $data_stat['title'];

    echo "<tr><td>";


   print " $title:</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\">";
    print "<img src=\"images/mainbar.gif\"  height=\"$m_size[1]\" width=". $rs[1] * 2 ."><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$l_size[0]\">
    </td><td>
    $rs[1] % ($rs[0])</td>
    </tr>\n";

}
print "</table>";
}else{
        print "<center>  ·«  ÊÃœ ‰ «∆Ã </center>";
        }
}

close_table();


  }


 //---------------------------- Pages -------------------------------------
 if($action=="pages"){
        $qr = db_query("select * from links_pages where active=1 and id='$id'");
         if(db_num($qr)){
         $data = db_fetch($qr);
         open_table("$data[title]");
                  run_php($data['content']);
                  close_table();
                  }else{
                  open_table();
                          print "<center>  ⁄›Ê« .. «·’›Õ… €Ì— „ÊÃÊœ… </center>";
                          close_table();
                          }
             }

  //--------------------- Copyrights ----------------------------------
 if($action=="copyrights"){
     open_table("«·ÕﬁÊﬁ «·»—„ÃÌ…");

     print "<center>
     „—Œ’ ·‹ : $_SERVER[SERVER_NAME]   „‰ <a href='http://allomani.biz/' target='_blank'>  «··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ… </a> <br><br>

    <font face=\"Tahoma\" style=\"font-size: 9pt\">
                        <span lang=\"ar-sa\"><font color=\"#336699\">Ã„Ì⁄ ÕﬁÊﬁ «·»—„Ã… „Õ›ÊŸ… </font>
                        <a target=\"_blank\" href=\"http://allomani.biz/\">
                        <font color=\"#336699\">··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ…</font></a><font color=\"#336699\">
                        © 2006</font></span></font>";
     close_table();
         }
//------------------------ Advertise -----------------------------------------------
$data=mysql_fetch_array(mysql_query("select * from links_adv where type='footer'"));
print $data['content'];
//---------------------  Banners ------------------------------------------------------
$qr = db_query("select * from links_banners where type='footer' order by ord");
while($data = db_fetch($qr)){
db_query("update links_banners set views=views+1 where id=$data[id]");
print "<center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a><br></center>";
        }
 print "<br>";




print "</td>  " ;
//---------------------------END OF CENTER CONTENT--------------------------------------
 $zqr=db_query("select * from links_blocks where pos='l' and active=1 order by ord");
 if(db_num($zqr)){
print "<td width=17% valign=\"top\">
<center><table width=100%>";


             $adv_c= 1 ;
         while($zdata = db_fetch($zqr)){
        print "<tr>
                <td  width=\"100%\" valign=\"top\">";
                open_block($zdata['title']);

                run_php($zdata['file']);

                close_block();

                print "</td>
        </tr>";

              //---------------------------------------------------

        $adv_menu_qr = db_query("select * from links_banners where type='menu' and menu_id=$adv_c and menu_pos='l' order by ord");
        if(db_num($adv_menu_qr)){
                $data = db_fetch($adv_menu_qr) ;
                db_query("update links_banners set views=views+1 where id=$data[id]");
                print "<tr>
                <td  width=\"100%\" valign=\"top\">";
               // open_block();
             print "<br><center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a></center><br>";
              // close_block();
                print "</td>
        </tr>";
               }
            ++$adv_c ;
        //----------------------------------------------------
           }

print "</table></center></td>";
}
 //----------------------------------------------------

print "</tr></table>\n";

 print "<div dir=rtl>";
 print_copyrights();
 print "</div>";


site_footer();