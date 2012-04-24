<?php

$modx->lexicon->load('importusersx:default');
if (isset($_FILES['userfile']) AND $_FILES['userfile']['error'] == 0)
{

	$sFileInformations = pathinfo($_FILES['userfile']['name']);
	$sExtension = $sFileInformations['extension'];
	if($sExtension == 'csv')
	{
		move_uploaded_file($_FILES['userfile']['tmp_name'], basename($_FILES['userfile']['name']));
		echo 'Upload completed';
	}
	else
	{
		echo '.csv required, received : .'.$sExtension;
	}
 
}
else if (isset($_FILES['userfile']) AND $_FILES['userfile']['error'] != 0)
{
	echo 'Upload error';
}

class ImportUsersXHomeManagerController extends ImportUsersXManagerController {
	
	public function process(array $scriptProperties = array()) {}
	
    public function getPageTitle() { return $this->modx->lexicon('importusersx'); }
	
    public function loadCustomCssJs() {
        
       $this->addJavascript($this->importusersx->config['jsUrl'].'mgr/widgets/home.panel.js');
       $this->addLastJavascript($this->importusersx->config['jsUrl'].'mgr/sections/index.js');
	   
    }
	
    public function getTemplateFile() { return $this->importusersx->config['templatesPath'].'home.tpl'; }
}