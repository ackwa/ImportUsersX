<?php

	include_once('../../core/config/config.inc.php');
	define('MODX_CONFIG_KEY', 'config');
	include_once (MODX_CORE_PATH . 'model/modx/modx.class.php');
	$modx = new modX();
	$modx->initialize('mgr');

	//Display to user the begining of building script
	echo 'Creating package';
	
	//Package variables
	define('PKG_NAME', 'ImportUsersX');
	define('PKG_NAME_LOWER', strtolower(PKG_NAME));
	define('PKG_VERSION', '1.0');
	define('PKG_RELEASE', 'beta1');
	
	/* define build paths */
	$root = dirname(dirname(__FILE__)).'/';
	$sources = array(
		'root' => $root,
		'build' => $root . '_build/',
		'data' => $root . '_build/data/',
		'resolvers' => $root . '_build/resolvers/',
		'chunks' => $root.'core/components/'.PKG_NAME_LOWER.'/chunks/',
		'lexicon' => $root . 'core/components/'.PKG_NAME_LOWER.'/lexicon/',
		'docs' => $root.'core/components/'.PKG_NAME_LOWER.'/docs/',
		'elements' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/',
		'source_assets' => $root.'assets/components/'.PKG_NAME_LOWER,
		'source_core' => $root.'core/components/'.PKG_NAME_LOWER,
		);
	unset($root);
 
	//Loading and creating the package
	$modx->loadClass('transport.modPackageBuilder', "", false, true);
	$builder = new modPackageBuilder($modx);
	$builder->createPackage(PKG_NAME, PKG_VERSION, PKG_RELEASE);
	$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/' .PKG_NAME_LOWER. '/');
	
	//Creating new category for the extra
	$category= $modx->newObject('modCategory');
	$category->set('category',PKG_NAME);

	//Adding the snippet
	$modx->log(modX::LOG_LEVEL_INFO,'Packaging in snippets...');
	$snippets = include $sources['data'].'transport.snippets.php';
	if (empty($snippets)) $modx->log(modX::LOG_LEVEL_ERROR,'Could not package in snippets.');
	$category->addMany($snippets);
	
	$attr = array(
    	xPDOTransport::UNIQUE_KEY => 'category',
    	xPDOTransport::PRESERVE_KEYS => false,
    	xPDOTransport::UPDATE_OBJECT => true,
    	xPDOTransport::RELATED_OBJECTS => true,
    	xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        	'Snippets' => array(
            	xPDOTransport::PRESERVE_KEYS => false,
            	xPDOTransport::UPDATE_OBJECT => true,
            	xPDOTransport::UNIQUE_KEY => 'name',
        		),
   			),
		);
		
	$vehicle = $builder->createVehicle($category,$attr);
	
	$modx->log(modX::LOG_LEVEL_INFO,'Adding package attributes and setup options...');
	$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
    'setup-options' => array(
        'source' => $sources['build'].'setup.options.php',
   		),
	));
		
	//Set the package up 
	$vehicle->resolve('php', array(
		'source' => $sources['build'].'setup.importusersx.php',
	));	

	$modx->log(modX::LOG_LEVEL_INFO,'Adding file resolvers to category...');
	$vehicle->resolve('file',array(
		'source' => $sources['source_assets'],
		'target' => "return MODX_ASSETS_PATH . 'components/';",
	));
	$vehicle->resolve('file',array(
		'source' => $sources['source_core'],
		'target' => "return MODX_CORE_PATH . 'components/';",
	));
	
	$builder->putVehicle($vehicle);

	//Zip up package
	$builder->pack();
	
	//End of Building
	echo '</br> Package complete';
?>