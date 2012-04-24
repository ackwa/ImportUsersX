<?php
/*
 * ImportUsersX :: import.php
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
/*
* Todo :
*
* - IHM
* - Utiliser les fonction de logs de MODX
*/

require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/core/model/modx/modx.class.php';
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/core/model/modx/modprocessor.class.php';
$modx = new modX();
$modx->initialize('mgr');

/*
 * Parameters
 *
 * $sGroup : MODX Users group name
 * $sEmailChunkName : Chunk's name for the email sent to the user
 * $sEmailAdminChunkName : Chunk's name for the email sent to the administrator
 * $bForcePasswordChange : Set if password have to be changed if a user already exists
 * $sCSVPath : Path to the CSV file
 * $sAdminUsername : Username of the administrator to send email to.
 */
 
$sGroup    = $_POST['groupName'];
$sEmailChunkName = $_POST['userMailChunkName'];
$sEmailAdminChunkName = $_POST['adminMailChunkName'];
$bForcePasswordChange = false; //Will soon be added
$sCSVPath  = dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/core/components/importusersx/controllers/'.$_POST['csvFilePath'];
$sAdminUsername = $modx->getOption('emailsender');

/* ----- END OF Parameters ----- */

$iAddCount = 0;
$iChangeCount = 0;
$sAddLog = '';
$sChangeLog = '';
if (($csv = fopen($sCSVPath,'r')) !== FALSE) {

	$modx->setLogLevel(modX::LOG_LEVEL_INFO);
	$modx->setLogTarget('ECHO');
	
	$modx->getService('lexicon','modLexicon');
	$modx->lexicon->load('fr:importusersx:default');
	
	//$sLog = $modx->lexicon('importusersx');
	$modx->log(modX::LOG_LEVEL_INFO,'Parsing CSV.');

	while(($data = fgetcsv($csv, 1000, ";")) !== FALSE)
	{
		$sFirstName	= trim($data[0]);
		$sLastName	= trim($data[1]);
		$sEmail		= trim($data[2]);
				
		//list($sAlias) = explode('@',$sEmail); //ModX username : mail - @domain.ext (ex: mail = login@domain.ext =>  username = login)
		$sAlias = trim($sEmail); //ModX username = mail
	
		//Based on code from Bob Ray
		$aFields = array(
			'username' => $sAlias,
			'email'    => $sEmail,
			'active'   => 1,
			'blocked'  => 0,
		);
		
		$user = $modx->getObject('modUser', array('username'=>$sAlias)); // Return 1 if user already exists, 0 otherwise
		
		if ( $user  && !$bForcePasswordChange ) //If exists and we haven't to force the password change
		{
			//Then only firstname and lastname are changed
			$modx->log(modX::LOG_LEVEL_INFO,'User already exists. Updating profile\'s informations.');
						
			//Based on code from culd | steffan
			$uid = $user->get('id');
			if( $userProfile = $modx->getObject('modUserProfile',array('internalKey' => $uid)))
			{
				$userProfile->set('fullname', $sFirstName. ' ' .$sLastName);
				
				$modx->log(modX::LOG_LEVEL_INFO,$sAlias.'\'s informations updated.');
				$sChangeLog .= $sAlias."\'s informations updated.\n";
				$iChangeCount++;
				
			}
			else
			{
				$modx->log(modX::LOG_LEVEL_ERROR,'Failed to update ' .$sAlias.'`s informations');
			}
							
			$userProfile->save();
			$modx->log(modX::LOG_LEVEL_INFO,$sAlias.'\'s profile saved.');
			
		}
		else
		{	
			//Else, we create a new user. It'll be overwritte if it already exists
			$modx->log(modX::LOG_LEVEL_INFO, 'Creating new user.');
			
			$user  = $modx->newObject('modUser', $aFields);
						
			$sPass = $user->generatePassword(7); //Generates a random password (ModX method)
			$user->set('password', $sPass);
				
			$user->save();
				
			//Based on code from culd | steffan
			$uid = $user->get('id');
			
			$userProfile = $modx->newObject('modUserProfile');
			$userProfile->fromArray(array(
				'internalKey' => $uid,
				'fullname'    => $sFirstName.' '.$sLastName,
				'email'       => $sEmail,
			));
			
			//Creates User Group		
			$memberGroup = $modx->newObject('modUserGroupMember');
			$memberGroup->fromArray(array(
				'user_group' => $sGroup,
				'member'     => $uid,
				'role'        => 2,
			));
			
			$memberGroup->save();
						
			$success = $user->addOne($userProfile); //Adds profile to created user
						
			if ($success) 
			{
				$sAddLog .= $user->get('username'). ' added <br/>';
				$iAddCount++;
				
				$user->joinGroup($sGroup);//Adds user to Group
				
				$user->save();
				$userProfile->save();
							
				$sMessage = $modx->getChunk($sEmailChunkName, 
					array(
						'alias'    => $sAlias,
						'password' => $sPass,
					)
				);
				
				$user->sendEmail($sMessage);
				
				$modx->log(modX::LOG_LEVEL_INFO,$sAlias.' added.');
			} 
			else 
			{
				$modx->log(modX::LOG_LEVEL_INFO,'Failed to add ' .$sAlias.'.');
			}
		}
	}
	
	$modx->log(modX::LOG_LEVEL_INFO,'Recovering administrator\'s profile.');
	
	$user = $modx->getObject('modUser', array('username'=>$sAdminUsername));
	 
	$modx->log(modX::LOG_LEVEL_INFO,'Recovering administor email chunk.');
		
	$sMessageAdmin = $modx->getChunk($sEmailAdminChunkName, 
		array(
			'addCount'    => $iAddCount, //Add variables to chunk
			'changeCount' => $iChangeCount,
			'addLog'      => $sAddLog,
			'changeLog'   => $sChangeLog,
		)
	);
		
	$modx->log(modX::LOG_LEVEL_INFO,'Sending email to administrator.');
		
	//$user->sendEmail($sMessageAdmin);
	$modx->getService('mail', 'mail.modPHPMailer');
	$modx->mail->set(modMail::MAIL_BODY, $sMessageAdmin);
	$modx->mail->set(modMail::MAIL_FROM, $modx->config['emailsender']);
	$modx->mail->set(modMail::MAIL_FROM_NAME, $modx->config['site_name']);
	$modx->mail->set(modMail::MAIL_SENDER, $modx->config['emailsender']);
	$modx->mail->set(modMail::MAIL_SUBJECT, 'ImportUsersX import results');
	$modx->mail->address('to', $modx->config['emailsender']);	
	$modx->mail->send();
	if (!$modx->mail->send()) {
    $modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the email: '.$modx->mail->mailer->ErrorInfo);
	}
	else
	{
		$modx->log(modX::LOG_LEVEL_INFO,'Email sent');
	}
	$modx->mail->reset();
		
	fclose($csv);
	
	unlink($sCSVPath);
	$modx->log(modX::LOG_LEVEL_INFO, 'CSV file deleted.');
		
	$modx->log(modX::LOG_LEVEL_INFO,'End of import.');
}
else 
{
	$modx->log(modX::LOG_LEVEL_ERROR,'Failed access CSV file.');
}