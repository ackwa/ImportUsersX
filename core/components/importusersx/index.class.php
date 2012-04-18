<?php
ini_set('display_errors', 1); 
ini_set('log_errors', 1); 
ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
error_reporting(E_ALL);

require_once dirname(__FILE__) . '/model/importusersx/importusersx.class.php';
abstract class ImportUsersXManagerController extends modExtraManagerController {
    /** @var Doodles $importusersx */
    public $importusersx;
    public function initialize() {
        $this->importusersx = new ImportUsersX($this->modx);
 
        $this->addCss($this->importusersx->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->importusersx->config['jsUrl'].'mgr/importusersx.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            ImportUsersX.config = '.$this->modx->toJSON($this->importusersx->config).';
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