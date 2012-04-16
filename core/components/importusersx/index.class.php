<?php
	require_once dirname(__FILE__) . '/model/importusersx/importusersx.class.php';
    	
    abstract class ImportUsersXManagerController extends modManagerController {
         
        public $importusersx;
        public function initialize() {
            $this->importusersx = new ImportUsersX($this->modx);
            $this->addCss($this->importusersx->config['cssUrl'].'mgr.css');
            //$this->addJavascript($this->importusersx->config['jsUrl'].'mgr/importusersx.js');
            /*$this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                ImportUsersX.config = '.$this->modx->toJSON($this->importusersx->config).';
            });
            </script>');*/
            return parent::initialize();
        }
        public function getLanguageTopics() {
            return array('importusersx:default');
        }
        public function checkPermissions() { return true;}
    }
      
      class IndexManagerController extends modExtraManagerController {
        public static function getDefaultController() { return 'home'; }
    }