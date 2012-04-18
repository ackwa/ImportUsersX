<?php
ini_set('display_errors', 1); 
ini_set('log_errors', 1); 
ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
error_reporting(E_ALL);
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
require_once('../../../../model/modx/modx.class.php');
require_once('../../../../model/modx/modprocessor.class.php');
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
 * ...
 */
$sGroup    = $_POST['groupName'];//'Membres';
$sEmailChunkName = $_POST['userMailChunkName'];//'AddUsersEmailChunk';
$sEmailAdminChunkName = $_POST['adminMailChunkName'];//'AddUsersEmailAdminChunk';
$bForcePasswordChange = false;
$sCSVPath  = $_POST['csvFilePath'];//$modx->getOption('assets_path').'/data/users.csv';
$sAdminUsername = $_POST['adminUsername'];//'tzoreol@gmail.com';

/* ----- END OF Parameters ----- */

$iAddCount = 0;
$iChangeCount = 0;
$sAddLog = '';
$sChangeLog = '';

if (($csv = fopen($sCSVPath,'r')) !== FALSE) {
    echo "Parsing CSV...\n";
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
 					echo "L'utilisateur existe déjà. Modification de ses informations.\n";
   					//On se contente de modifier ses informations de profil
					//Based on code from culd | steffan
					$uid = $user->get('id');
					if( $userProfile = $modx->getObject('modUserProfile',array('internalKey' => $uid)))
					{
						$userProfile->set('fullname', $prenom. ' ' .$nom);
						echo "Information de " .$alias. " modifiés.\n";//'Informations de <strong>' .$user->get('username'). '</strong> modifiés<br/>';
						$sChangeLog .= 'Modification des informations de ' .$user->get('username'). '<br/>';
						$iChangeCount++;
					}
					else
					{
						echo "Echec de modification de l'utilisateur " .$uid. "\n";//'Echec de modification des informations pour l\'utilisateur ' .$uid;
					}
						
					$userProfile->save();
					echo "Utilisateur sauvegardé.\n";
				}
				else
				{	
					//Sinon on crée un nouvel utilisateur (il sera écrasé s'il existe déjà)
					echo "Création d'un nouvel utilisateur.\n";
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
						echo "Utilisateur " .$alias. " ajouté.\n";//'<p>Utilisateur <strong>' .$alias. '</strong> ajouté</p><br/>';
					} 
					else 
					{
						echo "Echec de l'ajout de l'utilisateur " .$alias. ".\n";//'<p>Echec d\'ajout de l\'utilisateur <strong>' .$alias.' </strong></p><br/>';
					}
				}
    }
	echo "Récupération profil administrateur.\n";
	$user = $modx->getObject('modUser', array('username'=>$sAdminUsername));
	echo "Profil récupéré.\n";
	echo "Récupération du chunk pour l'email administrateur.\n";
	$sMessageAdmin = $modx->getChunk($sEmailAdminChunkName, array(
								  'addCount'    => $iAddCount,
								  'changeCount' => $iChangeCount,
								  'addLog'      => $sAddLog,
								  'changeLog'   => $sChangeLog,
								 ));
	echo "Chunk récupéré.\n";
	echo "Envoi du mail à l'administrateur.\n";
	$user->sendEmail($sMessageAdmin);
	echo "Mail envoyé.\n";
	
	fclose($csv);
	echo "Fin de l'importation des utilisateurs.\n";
}
else {
	echo "Echec d'accès au fichier\n";//'<p>Echec d\'accès au fichier CSV</p><br/>';
	$s = `ls`;
	echo $_POST['csvFilePath'];
}