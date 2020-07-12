<?php
/*******************************************************************
* $Id: comment_new.php 2 2006-12-11 20:49:07Z BitC3R0 $      *
* -----------------------------------------------------------      *
* RMSOFT Gallery System 2.0                                        *
* Sistema Avanzado de Galer�as                                     *
* CopyRight � 2005 - 2006. Red M�xico Soft                         *
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
* -----------------------------------------------------------      *
* comment_new.php:                                                 *
* Control de Comentarios                                           *
* -----------------------------------------------------------      *
* @copyright: � 2005 - 2006. BitC3R0.                              *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT GS v2.0                                         *
* @version: 0.1.4                                                  *
* @modificado: 02/03/2006 05:05:55 p.m.                            *
*******************************************************************/

include '../../mainfile.php';
$com_itemid = isset($HTTP_GET_VARS['com_itemid']) ? intval($HTTP_GET_VARS['com_itemid']) : 0;
if ($com_itemid > 0) {
    // Get file title
    $sql = "SELECT titulo,file FROM " . $xoopsDB->prefix('rmdp_imgs') . " WHERE id_img=" . $com_itemid . "";
    $result = $xoopsDB->query($sql);
    $row = $xoopsDB->fetchArray($result);
    $com_replytitle = $row['titulo'] != '' ? $row['titulo'] : $row['file'];
    include XOOPS_ROOT_PATH.'/include/comment_new.php';
}
?>

