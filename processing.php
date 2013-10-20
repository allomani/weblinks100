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


//------------------- Cats -----------------------------------
 if($action == "cat_del" || $action=="edit_cat_ok" || $action=="cat_add_ok"){

   if_admin();

  if($action =="cat_add_ok"){
  db_query("insert into links_cats (name,cat) values('$name','$cat')");
  header("Location: admin.php?action=cats&cat=$cat");
        }

//----------------------------------------------------------
 if($action=="cat_del"){
 if($id){
  $delete_array = get_cats($id);
  foreach($delete_array as $id_del){
     db_query("delete from links_cats where id=$id_del");
     db_query("delete from links_links where cat=$id_del");
     }
         }
          header("Location: admin.php?action=cats&cat=$cat");
 }
//-----------------------------------------------------------
 if($action=="edit_cat_ok"){

 db_query("update links_cats set name='$name' where id=$id");
  header("Location: admin.php?action=cats&cat=$cat");
         }
   }





 //----------------------- Links -----------------------
 if($action=="links_add_ok" || $action=="link_del" || $action=="link_edit_ok"){
     if_admin();
//--------------------------------------------
if($action=="links_add_ok"){
for ($i = 1; $i <= $add_limit; $i++)
{
if($name[$i]){
//$description =  trim($description);

db_query("insert into links_links (name,url,description,class,date,cat,active) values('$name[$i]','$url[$i]','$description[$i]','$class[$i]',now(),'$cat','1');");
}}
  header("Location: admin.php?action=cats&cat=$cat");
}
//------------------------------------------------
 if($action=="link_del"){
 if($id){
   db_query("delete from links_links where id='$id'");
         }
 if($cat){
 header("Location: admin.php?action=cats&cat=$cat");
 }else{
 header("Location: admin.php");
 }
         }
//------------------------------------------------
if($action=="link_edit_ok"){
if($name){
 db_query("update links_links set name='$name',url='$url',class='$class',description='$description' where id='$id'");
 }
 if($cat){
 header("Location: admin.php?action=cats&cat=$cat");
 }else{
 header("Location: admin.php");
 }
        }

 }





//----------------------- Blocks ------------------------
if($action=="del_block" || $action=="edit_block_ok" || $action=="add_block" || $action=="block_disable" || $action=="block_enable"){

 if_admin("blocks");

 $redirect_url = "admin.php?action=blocks" ;

 if($action=="block_disable"){
        db_query("update links_blocks set active=0 where id=$id");
        header("Location: $redirect_url");
        }

if($action=="block_enable"){
       db_query("update links_blocks set active=1 where id=$id");
        header("Location: $redirect_url");
        }

        if($action=="add_block"){
         db_query("insert into links_blocks(title,pos,file,ord,active)values('$title','$pos','$file','$ord','1')");
          header("Location: $redirect_url");
        }

    if ($action=="del_block"){
          db_query("delete from links_blocks where id='$id'");
           header("Location: $redirect_url");
            }

            if ($action=="edit_block_ok"){
                db_query("update links_blocks set title='$title',file='$file',pos='$pos',ord='$ord' where id='$id'");
                    header("Location: $redirect_url");
                    }
 }




//--------------------- Classes ---------------------------------
if($action=="class_del" || $action=="class_add_ok" || $action=="class_edit_ok"){
  if_admin();

  $redirect_url = "admin.php?action=classes" ;

       if($action=="class_add_ok"){
         db_query("insert into links_classes(name,before,after,special)values('$name','$before','$after','$special')");
          header("Location: $redirect_url");
        }

    if ($action=="class_del"){
          db_query("delete from links_classes where id='$id'");
          db_query("update links_links set class='0' where class='$id'");
           header("Location: $redirect_url");
            }

            if ($action=="class_edit_ok"){
                db_query("update links_classes set name='$name',before='$before',after='$after',special='$special' where id='$id'");
                    header("Location: $redirect_url");
                    }


        }
//-----------------------------------------------------------------------

 }else{
         header("Location: admin.php");
         }


?>