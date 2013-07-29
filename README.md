ImportUsersX
===

Description
---
**ImportUsersX** is an extra for **[MODX](http://www.modx.com)** Revolution wich helps you adding numerous users into your MODX using a .csv file.

Install
---
If you don't have the package yet, you can download it on [GitHub](https://github.com/ackwa/ImportUsers "GitHub").

1. Unzip it in a ImportUsersX folder, located at the root of your website.
2. Package the extra by running the build.transport.php file in the _build directory.

Once you've got the package install it via Package Manager (if you don't see it try to select "Search locally for packages" at the top of packages list.

### How to use ? ###
Once the extra installed, go to **Components > ImportUsersX** in your modX menu.

**> NOTE : You may have to refresh the page before *CSV File* field appears.**

1. Select the group you want to add the users to in **Users Group Name** field.
2. In **Admin Email Chunk** and **User Email Chunk** fields, you also can add your own chunks. Just type their name...
3. Then, select a **CSV File** from your computer. An exemple is given to you at the end of this readme to be sure that you have the good format.

Need more explanations ? Don't be shy ! Send a mail at [iux@ackwa.fr](mailto:iux@ackwa.fr)

Improvements
---
We want this tool as close as possible of your needs. So if your have a suggestion, feel free to  [create an issue on GitHub](https://github.com/ackwa/ImportUsersX/issues) or submit us your work (with pull requests on GitHub if it's possible). We also looking people to translate the extra and make it accessible for everyone.

Bug tracker
---
Have a bug? Please [create an issue here on GitHub!](https://github.com/ackwa/ImportUsersX/issues)

Authors
---
**Kevin Pausé**    

+ [@tzoreol](http://www.twitter.com/tzoreol)
+ <http://github.com/Tzoreol>
+ [kevin.pause@supinfo.com](mailto:kevin.pause@supinfo.com)

**Gildas Noël**

+ [@ackwa](http://twitter.com/ackwa)
+ <http://github.com/krismas>
+ [Ackwa.fr](http://www.ackwa.fr)
+ [info@ackwa.fr](mailto:info@ackwa.fr)

Thanks
---
We'd like to thanks Bob Ray, Shaun McCormick, Steffan Blockx and Romain Tripault for their help. Thank you for your patience because it wasn't always easy to understand us !

CSV File exemple
---

    Alfred;Amsterdam;alam@domain.ext  
    Benjamin;Baltimore;beba@domain.ext	
    Charles;Casablanca;chca@domain.ext	
    David;Danemark;dada@domain.ext	
    Edward;Edison;eded@domain.ext

**NO HEADERS!**

Copyright and license
---
Copyright 2012-2013 - [Ackwa.fr](http://www.ackwa.fr).

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this work except in compliance with the License. You may obtain a copy of the License in the LICENSE file, or at:

   <http://www.apache.org/licenses/LICENSE-2.0>

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.