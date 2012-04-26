<?php
/*
 * ImportUsersX :: transport.menu.php
 *
 * Copyright 2012 by Kévin PAUSÉ (kevin.pause@supinfo.com)
 * Development funded by Ackwa, agency based at Larçay, Indre-et-Loire, Centre, FRANCE.
 *
 * All rights reserved.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */
 
//Add action
$action= $modx->newObject('modAction');
$action->fromArray(array(
	'id' => 1,
    'namespace' => 'importusersx',
    'parent' => 0,
    'controller' => 'index',
    'haslayout' => true,
    'lang_topics' => 'importusersx:default',
    'assets' => '',
),'',true,true);
 
//Add menu
$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'importusersx',
    'parent' => 'components',
    'description' => 'importusersx.desc',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
),'',true,true);
$menu->addOne($action);
unset($menus);
 
return $menu;