/*
 * ImportUsersX :: home.panel.js
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

importUsersX.panel.Home = function(config) {
	
	config = config || {};
    Ext.apply(config,{
    	border: false
		,id: 'form'
        ,baseCls: 'modx-panel'
        ,items: [{
        	html: '<h2>' + _('importusersx') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-panel',
			layout: 'form',
			labelWidth: 200,
            items: [{
                		html: '<p>'+_('importusersx.intro')+'</p>',
                		border: false,
                		bodyCssClass: 'panel-desc',
        			},{
                        xtype: 'modx-combo-usergroup' ,
						renderer: true, 
						data: 'usergroup',
						fieldLabel: _('importusersx.groupName'),
                        name: 'groupName',
                        id: 'groupName',
						description: _('importusersx.groupName.desc'),
                        allowBlank: false,
                        //blankText: _('importusersx.noGroupName'),
						anchor: '40%',
                    },{
                        xtype: 'textfield', 
                        name: 'chunkAdmin',
						fieldLabel: _('importusersx.adminEmailChunk'),
                        id: 'chunkAdmin',
						description: _('importusersx.adminEmailChunk.desc'),
                        allowBlank: false,
						value: 'AdminEmailChunk',
                        //blankText: _('importusersx.noAdminEmailChunk'),
						anchor: '40%',
                    },{
                        xtype: 'textfield', 
                        name: 'chunkUser',
						fieldLabel: _('importusersx.userEmailChunk'),
                        id: 'chunkUser',
						description: _('importusersx.userEmailChunk.desc'),
                        allowBlank: false,
						value: 'UserEmailChunk',
                        blankText: _('importusersx.noUserEmailChunk'),
						anchor: '40%',
                    },{
						xtype: 'modx-panel',
						id: 'panel', 
						border: false
					},{
                        xtype: 'textarea', 
                        name: 'log',
                        id: 'log',
						width: '700',
						height: '300',
                        disabled: true,
                    },{
						xtype: 'hidden', 
                        name: 'csvFilePath',
                        id: 'csvFilePath',
					},{
						border: false,
						buttons: [{
							text: _('importusersx.button')
            				,id: 'importusersx-btn-export'
            				,handler: importusers
							,scope: this
						}]
					}]
        }]
	});
    importUsersX.panel.Home.superclass.constructor.call(this,config);
};

function importusers() {
	
	var groupName = Ext.get('groupName').getValue();
	var chunkUser = Ext.get('chunkUser').getValue();
	var chunkAdmin = Ext.get('chunkAdmin').getValue();
	var csvFile = Ext.get('csvFilePath').getValue();
	
	document.getElementById("log").value="Please wait.";
	
	if (window.XMLHttpRequest)
	{	
		req = new XMLHttpRequest();	
	}
	else if (window.ActiveXObject)
	{
		try 
		{
			req = new ActiveXObject("Msxml2.XMLHTTP");		
		}
		catch (e)
		{
			try 
			{
				req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {}
		}
	}

	req.open("POST", "../assets/components/importusersx/elements/import.php", true);

	req.onreadystatechange = function()
	{ 
	 if(req.readyState == 4)
		{
			if(req.status == 200 || req.status == 0)
			{
				document.getElementById("log").value=req.responseText;
			}
			else
			{
				document.getElementById("log").value="Error: returned status code " + req.status + " - " + req.statusText;
			}
		} 
	};

	req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	var data = 'groupName=' + escape(groupName)+ '&userMailChunkName=' + escape(chunkUser) + '&adminMailChunkName=' + escape(chunkAdmin)+ '&csvFilePath=' + escape(csvFile);
	req.send(data);
	
}
Ext.extend(importUsersX.panel.Home,MODx.Panel);
Ext.reg('importusersx-panel-home',importUsersX.panel.Home);

window.onload = function (){
	
	var onChange = "AIM.submit(this.form, {'onStart' : startCallbackform, 'onComplete' : completeCallbackform})";
  var uploadForm = document.createElement('form');
  uploadForm.setAttribute('id','upload');
  uploadForm.setAttribute('method',"POST");
  uploadForm.setAttribute('enctype',"multipart/form-data");
  uploadForm.setAttribute('action',"../core/components/importusersx/controllers/home.class.php");
  uploadForm.innerHTML = '<div class="x-form-item">' + 
						 '<label name="csvFile" id="csvFile" class="x-form-item-label" style="width: 200px; margin-right: 2px;">' + 
						 _('importusersx.csvFile') + 
						 '</label><input type="file" id="csvPath" class="x-form-field-wrap x-form-field-trigger-wrap"  style="width: 300px;" name="userfile" onChange="'+onChange+';this.form.submit();"/>' +
						 '</div>';
	Ext.get("panel").appendChild(uploadForm);
	
};

AIM = {

    frame : function(c) {

        var n = 'f' + Math.floor(Math.random() * 99999);
        var d = document.createElement('DIV');
        d.innerHTML = '<iframe style="display:none" src="about:blank" id="'+n+'" name="'+n+'" onload="AIM.loaded(\''+n+'\')"></iframe>';
        document.body.appendChild(d);

        var i = document.getElementById(n);
        if (c && typeof(c.onComplete) == 'function') {
            i.onComplete = c.onComplete;
        }

        return n;
    },

    form : function(f, name) {
        f.setAttribute('target', name);
    },

    submit : function(f, c) {
        AIM.form(f, AIM.frame(c));
        if (c && typeof(c.onStart) == 'function') {
            return c.onStart();
        } else {
            return true;
        }
    },

    loaded : function(id) {
        var i = document.getElementById(id);
        if (i.contentDocument) {
            var d = i.contentDocument;
        } else if (i.contentWindow) {
            var d = i.contentWindow.document;
        } else {
            var d = window.frames[id].document;
        }
        if (d.location.href == "about:blank") {
            return;
        }

        if (typeof(i.onComplete) == 'function') {
            i.onComplete(d.body.innerHTML);
        }
    }
}

function startCallbackform() {
            //alert('start');
                // make something useful before submit (onStart)
                return true;
            }

 function completeCallbackform(response) {
                // make something useful after (onComplete)
                //MODx.fireResourceFormChange();
                var d = Ext.get('log');
                if (response) {
                    //document.getElementById("upload").value=response;
                    d.update(response);
                    } else {
                      
                      d.update('');
        
		              }
		var file = document.getElementById('csvPath').value;
		var spl = file.split('\\');
		if(spl[1] == undefined)
		{
			document.getElementById('csvFilePath').value = file;
		}
		else if(spl[1].search('fakepath') != -1)
		{
			document.getElementById('csvFilePath').value = spl[2];
		}
		
		//document.getElementById("log").value = Ext.get("csvPath").getValue();		
                //alert('complite');
               // document.getElementById('nr').innerHTML = parseInt(document.getElementById('nr').innerHTML) + 1;
               // document.getElementById('r').innerHTML = response;
            }