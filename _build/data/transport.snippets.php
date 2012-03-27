<?php

$snippets = array();
 
$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'ImportUsersSnippet',
    'description' => 'ImportUsersSnippet 1.0 beta1 - Import users to MODX from a CSV file',
    'snippet' => file_get_contents($sources['elements'].'snippets/snippet.importusersx.php'),),'',true,true);
	
return $snippets;