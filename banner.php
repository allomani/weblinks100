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

db_query("update links_banners set clicks=clicks+1 where id='$id'");
$data = db_qr_fetch("select url from links_banners where id='$id'");
header("Location: $data[url]");
?>

