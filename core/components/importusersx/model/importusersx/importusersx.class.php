<?php
	
	/*
	 * Based on Shaun McCormick's code <shaun+modextra@modx.com>
	 * Link : https://github.com/splittingred/modExtra/blob/develop/core/components/modextra/model/modextra/modextra.class.php
	 */
	 
	 class ImportUsersX
{
	function __construct(modX &$modx,array $config = array()) {

		$this->modx =& $modx;
 
		$basePath = $this->modx->getOption('importusersx.core_path',$config,$this->modx->getOption('core_path').'components/importusersx/');
		$assetsUrl = $this->modx->getOption('importusersx.assets_url',$config,$this->modx->getOption('assets_url').'components/importusersx/');

		$this->config = array_merge(array(
			'basePath' => $basePath,
			'corePath' => $basePath,
			'modelPath' => $basePath.'model/',
			'processorsPath' => $basePath.'processors/',
			'chunksPath' => $basePath.'elements/chunks/',
			'jsUrl' => $assetsUrl.'js/',
			'cssUrl' => $assetsUrl.'css/',
			'assetsUrl' => $assetsUrl,
			'connectorUrl' => $assetsUrl.'connector.php',
			'templatesPath' => $basePath.'templates/',
		), $config);

		$this->modx->addPackage('importusersx', $this->config['modelPath']);
	}
}

?>