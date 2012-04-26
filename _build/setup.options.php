<?php
/*
 * ImportUsersX :: setup.options.php
 *
 * Copyright 2012 by Kévin PAUSÉ (kevin.pause@supinfo.com)
 * Development funded by Ackwa, agency based at Larçay, Indre-et-Loire, Centre, FRANCE.
 *
 * All rights reserved.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */
 	
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