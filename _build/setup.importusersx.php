<?php
	
	//Install package with selected configuration
	
	$modx =& $object->xpdo;
	$default_template = $modx->config['default_template'];
	
	$success = false;
	switch( $options[xPDOTransport::PACKAGE_ACTION])
	{
		case xPDOTransport::ACTION_INSTALL:
			if( isset($options['create_document']) && $options['create_document'] == 'Yes')
			{
				$modx->log(xPDO::LOG_LEVEL_INFO, "Creating AddUsers document");
				$r = $modx->newObject('modResource');
                $r->set('class_key', 'modDocument');
				$r->set('context_key', 'web');
				$r->set('type', 'document');
				$r->set('contentType', 'text/html');
				$r->set('pagetitle', 'AddUsers');
				$r->set('longtitle', 'AddUsers Page');
				$r->set('description', 'Executes and shows output of ImportUsers Snippet');
				$r->set('alias', 'addusers');
				$r->set('published', '1');
				$r->set('parent', '0');
				$r->setContent('[[ImportUsersSnippet]]');
				$r->set('richtext', '0');
				$r->set('menuindex', '99');
				$r->set('searchable', '1');
				$r->set('cacheable', '1');
				$r->set('hidemenu', '1');
				$r->set('template', $default_template);
				$r->save();
				$success = true;
			}
			break;
		case xPDOTransport::ACTION_UPGRADE:
			$success = true;
			break;
		case xPDOTransport::ACTION_UNINSTALL:
			if( false === $modx->removeObject('modResource', array('name' => 'AddUsers')))
			{
				$modx->log(xPDO::LOG_LEVEL_INFO, "<br/><strong>NOTE: You may to remove the AddUsers Page manually</strong><br/>");
			}
			$success = true;
			break;
	}
	
	return $success;