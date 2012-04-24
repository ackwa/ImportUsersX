<?php
	
//Install package with selected configuration
	
$output = '';
switch( $options[xPDOTransport::PACKAGE_ACTION])
{
	case xPDOTransport::ACTION_INSTALL:
		$output = '<h2>You are going to install ImportUsersX</h2>';
		break;
	case xPDOTransport::ACTION_UPGRADE:
		break;
	case xPDOTransport::ACTION_UNINSTALL:
			if( false === $modx->removeObject('modChunk', array('name' => 'UserEmailChunk')))
				{
					$modx->log(xPDO::LOG_LEVEL_INFO, "<br/><strong>NOTE: You may to remove UserEmailChunk manually</strong><br/>");
				}
			if( false === $modx->removeObject('modChunk', array('name' => 'AdminEmailChunk')))
				{
					$modx->log(xPDO::LOG_LEVEL_INFO, "<br/><strong>NOTE: You may to remove AdminEmailChunk manually</strong><br/>");
				}
		break;
}
	
return $output;