<?php
/*
* Todo :
*
* - E-mail à partir d'un document MODX *Fait à voir pourquoi tout le html n'est pas envoyé*
* - Tester si l'utilisateur n'existe pas déjà *Fait*
* - Utiliser fgetcsv() *Fait*
* - E-mail de synthèse à l'administrateur *Fait*
*
* - Mise en forme code
* - Commentaires en anglais si partage avec communauté MODX 
* - IHM
* - Packaging MODX
* - Utiliser les fonction de logs de MODX
* - Le fichier CSV doit être hors de la racine web
*/
global $modx;

/*
 * Parameters
 *
 * $sGroup : MODX Users group name
 * $sEmailChunkName : Chunk's name for the email sent to the user
 * $sEmailAdminChunkName : Chunk's name for the email sent to the administrator
 * $bForcePasswordChange : Set if password have to be changed if a user already exists
 * $sCSVPath : Path to the CSV file
 * $sAdminUsername : Username of the administrator to send email to.
 * ...
 */
 
$sGroup    = 'Membres';
$sEmailChunkName = 'AddUsersEmailChunk';
$sEmailAdminChunkName = 'AddUsersEmailAdminChunk';
$bForcePasswordChange = false;
$sCSVPath  = $modx->getOption('assets_path').'/data/users.csv';
$sAdminUsername = 'tzoreol@gmail.com';

/* ----- END OF Parameters ----- */

$iAddCount = 0;
$iChangeCount = 0;
$sAddLog = '';
$sChangeLog = '';

if (($csv = fopen($sCSVPath,'r')) !== FALSE) {
    
    while(($data = fgetcsv($csv, 1000, ";")) !== FALSE)
    {
    	    $prenom = trim($data[0]);
			$nom = trim($data[1]);
    		$email = trim($data[2]);
			
    		//list($alias) = explode('@',$email); //On récupère l'identifiant de l'email afin qu'il soit le même pour ModX 
            $alias = trim($email);

    		//Based on code from Bob Ray
    		$fields = array(
    			'username' => $alias,
    			'email'    => $email,
    			'active'   => 1,
    			'blocked'  => 0,
    			);
				
				$user = $modx->getObject('modUser', array('username'=>$alias)); // Sera 1 s'il existe, 0 sinon
				if ( $user  && !$bForcePasswordChange ) //Si l'utilisateur existe et qu'on ne doit pas forcer le changement de mot de passe
				{
 
   					//On se contente de modifier ses informations de profil
					//Based on code from culd | steffan
					$uid = $user->get('id');
					if( $userProfile = $modx->getObject('modUserProfile',array('internalKey' => $uid)))
					{
						$userProfile->set('fullname', $prenom. ' ' .$nom);
						echo 'Informations de <strong>' .$user->get('username'). '</strong> modifiés<br/>';
						$sChangeLog .= 'Modification des informations de ' .$user->get('username'). '<br/>';
						$iChangeCount++;
					}
					else
					{
						echo 'Echec de modification des informations pour l\'utilisateur ' .$uid;
					}
						
					$userProfile->save();
				}
				else
				{	
					//Sinon on crée un nouvel utilisateur (il sera écrasé s'il existe déjà)
    				$user  = $modx->newObject('modUser', $fields);
					
            		$sPass = $user->generatePassword(7); //Génération du mot de passe
            		$user->set('password', $sPass);
    		
    				$user->save();
    		
					//Based on code from culd | steffan
					$uid = $user->get('id');
					$userProfile = $modx->newObject('modUserProfile');
					$userProfile->fromArray(array(
						'internalKey' => $uid,
						'fullname'    => $prenom.' '.$nom,
						'email'       => $email,
						));
    			
    				$memberGroup = $modx->newObject('modUserGroupMember');
					$memberGroup->fromArray(array(
						'user_group' => $sGroup,
						'member'     => $uid,
						'role'        => 2,
						));
    				$memberGroup->save();
					
    				$success = $user->addOne($userProfile);
					
					if ($success) 
					{
						$sAddLog .= 'Ajout de ' .$user->get('username'). '<br/>';
						$iAddCount++;
						$user->joinGroup($sGroup);
						$user->save();
						$userProfile->save();
						
						$sMessage = $modx->getChunk($sEmailChunkName, array(
								  'alias'    => $alias,
								  'password' => $sPass,
								 ));
						$user->sendEmail($sMessage);
						echo '<p>Utilisateur <strong>' .$alias. '</strong> ajouté</p><br/>';
					} 
					else 
					{
						echo '<p>Echec d\'ajout de l\'utilisateur <strong>' .$alias.' </strong></p><br/>';
					}
				}
    }
	$user = $modx->getObject('modUser', array('username'=>$sAdminUsername));
	$sMessageAdmin = $modx->getChunk($sEmailAdminChunkName, array(
								  'addCount'    => $iAddCount,
								  'changeCount' => $iChangeCount,
								  'addLog'      => $sAddLog,
								  'changeLog'   => $sChangeLog,
								 ));
	$user->sendEmail($sMessageAdmin);
	
	fclose($csv);
}
else {
	echo '<p>Echec d\'accès au fichier CSV</p><br/>';
}