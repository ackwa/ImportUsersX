<?php
/*
 * ImportUsersX :: home.class.php
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

if (isset($_FILES['userfile']) AND $_FILES['userfile']['error'] == 0)
{

	$sFileInformations = pathinfo($_FILES['userfile']['name']);
	$sExtension = $sFileInformations['extension'];
	if($sExtension == 'csv')
	{
		move_uploaded_file($_FILES['userfile']['tmp_name'], basename($_FILES['userfile']['name']));
		echo 'Upload completed';
	}
	else
	{
		echo '.csv required, received : .'.$sExtension;
	}
 
}
else if (isset($_FILES['userfile']) AND $_FILES['userfile']['error'] != 0)
{
	echo 'Upload error';
}
else
{
	class ImportUsersXHomeManagerController extends ImportUsersXManagerController {
		
		public function process(array $scriptProperties = array()) {}
		
		public function getPageTitle() { return $this->modx->lexicon('importusersx'); }
		
		public function loadCustomCssJs() {
			
		   $this->addJavascript($this->importusersx->config['jsUrl'].'mgr/widgets/home.panel.js');
		   $this->addLastJavascript($this->importusersx->config['jsUrl'].'mgr/sections/index.js');
		   
		}
		
		public function getTemplateFile() { return $this->importusersx->config['templatesPath'].'home.tpl'; }
	}
}