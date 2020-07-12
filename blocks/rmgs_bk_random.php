<?php
/*******************************************************************
* $Id: rmgs_bk_random.php 2 2006-12-11 20:49:07Z BitC3R0 $   *
* --------------------------------------------------------------   *
* RMSOFT Gallery System 2.0                                        *
* Sistema Avanzado de Galeras                                     *
* CopyRight  2005 - 2006. Red Mxico Soft                         *
* http://www.redmexico.com.mx                                      *
* http://www.xoops-mexico.net                                      *
*                                                                  *
* This program is free software; you can redistribute it and/or    *
* modify it under the terms of the GNU General Public License as   *
* published by the Free Software Foundation; either version 2 of   *
* the License, or (at your option) any later version.              *
*                                                                  *
* This program is distributed in the hope that it will be useful,  *
* but WITHOUT ANY WARRANTY; without even the implied warranty of   *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the     *
* GNU General Public License for more details.                     *
*                                                                  *
* You should have received a copy of the GNU General Public        *
* License along with this program; if not, write to the Free       *
* Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,   *
* MA 02111-1307 USA                                                *
*                                                                  *
* --------------------------------------------------------------   *
* rmgs_bk_random.php:                                              *
* Bloque que muestra una imgen aleatoria                          *
* --------------------------------------------------------------   *
* @copyright:  2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.2.6                                                  *
* @modificado: 01/03/2006 07:04:19 p.m.                            *
*******************************************************************/

require_once XOOPS_ROOT_PATH.'/modules/rmgs/include/block.func.php';

function rmgs_bk_random(){
	global $xoopsConfig;
	
	$db = Database::getInstance();
	list($num) = $db->fetchRow($db->query("SELECT COUNT(*) FROM ".$db->prefix("rmgs_imgs")));

	if ($num<=0){ return; }
	
	$find = rand(0, $num-1);
	
	$result = $db->query("SELECT * FROM ".$db->prefix("rmgs_imgs")." LIMIT $find,1");
	
	$row = $db->fetchArray($result);
	
	$mc = rmgs_bkget_config('rmgs');
	$user = new XoopsUser($row['idu']);
	$dir = $mc['storedir'];
	$dir = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $dir);
	if (substr($dir, strlen($dir) - 1, 1) != '/'){ $dir .= '/'; }
	$user = new XoopsUser($row['idu']);
	$ver = str_replace("XOOPS ", '', XOOPS_VERSION);
	if (substr($ver, 0, 3)=='2.2'){
		$uname = $user->getVar('loginname');
	} else {
		$uname = $user->getVar('uname');
	}
	$rtn = array();
	$rtn['id'] = $row['id_img'];
	$rtn['file'] = $dir . $uname . '/ths/' . $row['file'];
	$rtn['title'] = $row['titulo'];
	return $rtn;
}

function rmgs_bk_random_images($options){
	global $xoopsTpl;
	
	$db = Database::getInstance();
	$mc = rmgs_bkget_config('rmgs');

	$dir = $mc['storedir'];
	$dir = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $dir);
	
	$result = $db->query("SELECT * FROM ".$db->prefix("rmgs_imgs")." ORDER BY RAND() LIMIT 0, $options[0]");
	$block = array();
	$i=1;
	while ($row = $db->fetchArray($result)){
		$rtn = array();
		$rtn['id'] = $row['id_img'];
		$rtn['title'] = $row['titulo'];
		$user = new XoopsUser($row['idu']);
		$ver = str_replace("XOOPS ", '', XOOPS_VERSION);
		if (substr($ver, 0, 3)=='2.2'){
			$uname = $user->getVar('loginname');
		} else {
			$uname = $user->getVar('uname');
		}
		$rtn['file'] = $dir . '/' . $uname . '/ths/' . $row['file'];
		$rtn['user'] = $uname;
		$rtn['userid'] = $row['idu'];
		$rtn['date'] = date($mc['format_date'], $row['update']);
		$block['images'][$i] = $rtn;
		$i++;
	}
	
	$xoopsTpl->assign('num_cols', $options[1]);
	$xoopsTpl->assign('rmgs_lang_by', _BK_RMGS_BY);
	$xoopsTpl->assign('rmgs_lang_date', _BK_RMGS_DATE);
	return $block;
}

function rmgs_bk_random_images_edit($options){
	$form = _MI_RMGS_BKREC_NUMBER."<br /><input type='text' size='5' name='options[0]' value='$options[0]' />";
	$form .= "<br />";
	$form .= "<br />"._MI_RMGS_BKCOL_NUMBER;
	$form .= "<br /><input type='text' size='2' name='options[1]' value='$options[1]' />";
	return $form;
}

?>