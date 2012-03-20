ImportUsers
===

Description
---
ImportUsers is a snippet for ModX (it will soon be an add-on) wich helps you adding numerous users into your Modx using a .csv file.

Documentation
---

### Parameters ###
$sGroup : Name of the group to add members in.  
$sEmailChunkName : Chunk's name for the email sent to the user.  
$sEmailAdminChunkName : Chunk's name for the email sent to the administrator.  
$bForcePasswordChange : Set if password have to be changed if a user already exists.  
$sCSVPath : Path to the CSV file.  
$sAdminUsername : Username of the administrator to send email to.  

### Other variables ###
**These variables must not be changed !**  

$iAddCount : Counts how many users are added into Modx.    
$sChangecount : Count hiw many users are updated into Modx.  
$sAddLog : List all of added users. 
$sChangeLog : List all of updated users.  

Need more explanations ? Don't be shy ! Send a mail at <kevin.pause@supinfo.com>

Bug tracker
---
Have a bug, a suggestion? Please [create an issue here on GitHub!](https://github.com/ackwa/xboot/issues)

Author
---
**Kevin Pausé**, **Gildas Noël**

+ [@ackwa](http://twitter.com/ackwa)
+ <http://github.com/krismas>
+ [Ackwa.fr](http://www.ackwa.fr)


Copyright and license
---
Copyright 2012 - [Ackwa.fr](http://www.ackwa.fr).

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this work except in compliance with the License.
You may obtain a copy of the License in the LICENSE file, or at:

   <http://www.apache.org/licenses/LICENSE-2.0>

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.