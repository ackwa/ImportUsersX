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
                        xtype: 'textfield',
						hideLabel: false,
						fieldLabel: _('importusersx.groupName'),
                        name: 'groupName',
                        id: 'groupName',
						description: _('importusersx.groupName.desc'),
                        allowBlank: false,
                        blankText: _('importusersx.noGroupName'),
						anchor: '40%',
                    },{
                        xtype: 'textfield', 
                        name: 'chunkAdmin',
						fieldLabel: _('importusersx.adminEmailChunk'),
                        id: 'chunkAdmin',
						description: _('importusersx.adminEmailChunk.desc'),
                        allowBlank: false,
                        blankText: _('importusersx.noAdminEmailChunk'),
						anchor: '40%',
                    },{
                        xtype: 'textfield', 
                        name: 'chunkUser',
						fieldLabel: _('importusersx.userEmailChunk'),
                        id: 'chunkUser',
						description: _('importusersx.userEmailChunk.desc'),
                        allowBlank: false,
                        blankText: _('importusersx.noUserEmailChunk'),
						anchor: '40%',
                    },{
                        xtype: 'modx-combo-browser',
						fieldLabel: _('importusersx.csvFile'),
                        name: 'csv-file',
                        id: 'csv-file',
						description: _('importusersx.csvFile.desc'),
						allowBlank: false,
						blankText: _('importusersx.noCsvFile'),
						anchor: '40%',
                    },{
                        xtype: 'textfield', 
                        name: 'adminUsername',
						fieldLabel: _('importusersx.adminUsername'),
                        id: 'adminUsername',
						description: _('importusersx.adminUserneame.desc'),
                        allowBlank: false,
                        blankText: _('importusersx.noAdminUsername'),
						anchor: '40%',
                    },
					{
                        xtype: 'textarea', 
                        name: 'log',
                        id: 'log',
						width: '700',
						height: '300',
                        disabled: true,
                    },{
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
	var adminUsername = Ext.get('adminUsername').getValue();
	var csvFile = Ext.get('csv-file').getValue();
	
	
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
	var data = 'groupName=' + escape(groupName)+ '&userMailChunkName=' + escape(chunkUser) + '&adminMailChunkName=' + escape(chunkAdmin) + '&adminUsername=' + escape(adminUsername)+ '&csvFilePath=' + escape(csvFile);//    ;		
	req.send(data);
	
}

Ext.extend(importUsersX.panel.Home,MODx.Panel);
Ext.reg('importusersx-panel-home',importUsersX.panel.Home);