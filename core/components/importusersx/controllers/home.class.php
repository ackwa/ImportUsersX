<?php

class ImportUsersXHomeManagerController extends ImportUsersXManagerController {
	
	public function process(array $scriptProperties = array()) {}
	
    public function getPageTitle() { return $this->modx->lexicon('importusersx'); }
	
    public function loadCustomCssJs() {
        
       $this->addJavascript($this->importusersx->config['jsUrl'].'mgr/widgets/home.panel.js');
       $this->addLastJavascript($this->importusersx->config['jsUrl'].'mgr/sections/index.js');
	   
    }
	
    public function getTemplateFile() { return $this->importusersx->config['templatesPath'].'home.tpl'; }
}