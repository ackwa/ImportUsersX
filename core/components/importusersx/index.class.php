<?php

require_once dirname(__FILE__) . '/model/importusersx/importusersx.class.php';

abstract class ImportUsersXManagerController extends modExtraManagerController {
 
    public $importusersx;
	
    public function initialize() {
        $this->importusersx = new ImportUsersX($this->modx);
 
        $this->addCss($this->importusersx->config['cssUrl'].'mgr.css'); //No needed for now
        $this->addJavascript($this->importusersx->config['jsUrl'].'mgr/importusersx.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            importUsersX.config = '.$this->modx->toJSON($this->importusersx->config).';
        });
        </script>');
        return parent::initialize();
    }
	
    public function getLanguageTopics() {
        return array('importusersx:default');
    }
	
    public function checkPermissions() { return true;}
}

class IndexManagerController extends ImportUsersXManagerController {
    public static function getDefaultController() { return 'home'; }
}