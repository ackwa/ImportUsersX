<?php
/*
 * ImportUsersX :: transport.chunks.php
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