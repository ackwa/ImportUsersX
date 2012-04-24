<?php

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