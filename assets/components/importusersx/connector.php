<?php

	/* 
	 * Based on Shaun McCormick's code <shaun+modextra@modx.com>
	 * Link : https://github.com/splittingred/modExtra/blob/develop/assets/components/modextra/connector.php
 	 */
	 
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('importusersx.core_path',null,$modx->getOption('core_path').'components/importusersx/');
require_once $corePath.'model/importusersx/importusersx.class.php';
$modx->importusersx = new ImportUsersX($modx);

$modx->lexicon->load('importusersx:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->importusersx->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));