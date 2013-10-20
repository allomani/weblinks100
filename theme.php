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

function get_template($name){


$data = db_qr_fetch("select * from links_templates where name like '$name'");

return $data['content'] ;
}



$theme['header'] = get_template("header") ;
$theme['footer'] = get_template("footer") ;
$theme['table'] = split("{content}",get_template("table")) ;
$theme['block'] = split("{content}",get_template("block")) ;

$theme['table_open'] = $theme['table'][0] ;
$theme['table_close'] = $theme['table'][1] ;

$theme['block_open'] = $theme['block'][0] ;
$theme['block_close'] = $theme['block'][1] ;

function site_header(){
global $theme,$sitename,$settings,$action,$id,$op,$cat,$section_name;

if($section_name){
$sec_name = " -  $section_name" ;
        }

print "<HTML dir=$settings[html_dir]>
<META name=keywords content=\"www.allomani.com, allomani, allomani.com , ÇááæãÇäí , $settings[header_keywords] \" >
<META name=\"Developer\" content=\"www.allomani.com\" >
<title>$sitename".$sec_name.$title_sub."</title>";


run_php($theme['header']);

print "<script>

function vote_link(id)
{

msgwindow=window.open(\"vote_link.php?id=\"+id,\"displaywindow\",\"toolbar=no,scrollbars=no,width=350,height=250,top=200,left=200\")
}

function add2fav(id)
{

msgwindow=window.open(\"add2fav.php?id=\"+id,\"displaywindow\",\"toolbar=no,scrollbars=no,width=350,height=250,top=200,left=200\")
}

 </script>\n";
}

function site_footer (){
global $theme;
print $theme['footer'];
}


function open_block($table_title=""){
global $theme;
      $table_content = $theme['block_open'];
if($table_title){

        $table_content = str_replace("{title}","$table_title", $theme['block_open']);

        }else{
            $table_content = str_replace("{title}","", $theme['table_open']);
                }

print $table_content ;
}

function close_block(){
global $theme;
print $theme['block_close'];
}


function open_table($table_title=""){
global $theme;
      $table_content = $theme['table_open'];
if($table_title){

        $table_content = str_replace("{title}","$table_title", $theme['table_open']);

        }else{
            $table_content = str_replace("{title}","", $theme['table_open']);
                }

print $table_content ;
}

function close_table(){
global $theme;
print $theme['table_close'];
}

?>