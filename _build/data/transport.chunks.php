<?php
function getChunkContent($filename) {
    $o = file_get_contents($filename);
    return $o;
}

$chunks = array();
 
$chunks[1]= $modx->newObject('modChunk');
$chunks[1]->fromArray(array(
    'name' => 'UserEmailChunk',
    'description' => 'Chunk for the email which will be sent to the user.',
    'snippet' => getChunkContent($aSources['chunks'].'userEmail.chunk.php'),
),'',true,true);

$chunks[2]= $modx->newObject('modChunk');
$chunks[2]->fromArray(array(
    'name' => 'AdminEmailChunk',
    'description' => 'Chunk for the email which will be sent to the administrator.',
    'snippet' => getChunkContent($aSources['chunks'].'adminEmail.chunk.php'),
),'',true,true);
 
return $chunks;