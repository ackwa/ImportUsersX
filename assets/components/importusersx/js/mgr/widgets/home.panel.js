importUsersX.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
		,id: 'form'
		,buttons: [{
			text: 'oui'
            ,id: 'importusersx-btn-export'
            ,handler: importusers
			,scope: this
		}]
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>' + _('importusersx') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-panel',
			layout: 'form',
            items: [{
                        xtype: 'textfield',
						hideLabel: false,
						fieldLabel: 'Nom du Groupe',
                        name: 'groupName',
                        id: 'groupName',
                        allowBlank: false,
                        blankText: _('importusersx.noGroupName')
                    },{
                        xtype: 'textfield', 
                        name: 'chunkAdmin',
						fieldLabel: 'Chunk Email Admin',
                        id: 'chunkAdmin',
                        allowBlank: false,
                        blankText: _('importusersx.noGroupName')
                    },{
                        xtype: 'textfield', 
                        name: 'chunkUser',
						fieldLabel: 'Chunk Email User',
                        id: 'chunkUser',
                        allowBlank: false,
                        blankText: _('importusersx.noGroupName')
                    },{
                        xtype: 'modx-combo-browser',
						fieldLabel: 'Fichier CSV',
                        name: 'csv-file',
                        id: 'csv-file',
                    },{
                        xtype: 'textfield', 
                        name: 'adminUsername',
						fieldLabel: 'Nom utilisateur Admin',
                        id: 'adminUsername',
                        allowBlank: false,
                        blankText: _('importusersx.noGroupName')
                    },
					{
                        xtype: 'textarea', 
                        name: 'test',
                        id: 'test',
						width: '500',
						height: '500',
                       disabled: true,
                    }]
                }
			]
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

	req.open("POST", "../assets/components/importusersx/elements/test.php", true);

	req.onreadystatechange = function()
	{ 
		Ext.get('test').set({value: 'changed'});
		if(req.readyState == 4)
		{
			if(req.status == 200 || req.status == 0)
			{
				document.getElementById("test").value=req.responseText;
			}
			else
			{
				document.getElementById("test").value="Error: returned status code " + req.status + " " + req.statusText;
			}
		} 	
	};

	req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	var data = 'groupName=' + escape(groupName)+ '&userMailChunkName=' + escape(chunkUser) + '&adminMailChunkName=' + escape(chunkAdmin) + '&adminUsername=' + escape(adminUsername)+ '&csvFilePath=' + escape(csvFile);//    ;		
	req.send(data);
	
}
Ext.extend(importUsersX.panel.Home,MODx.Panel);
Ext.reg('importusersx-panel-home',importUsersX.panel.Home);