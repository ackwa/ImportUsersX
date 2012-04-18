Ext.onReady(function() {
	
    MODx.load({ xtype: 'importusersx-page-home'});
	
});
 
importUsersX.page.Home = function(config) {
	
    config = config || {};
    Ext.applyIf(config,{
    	components: [{
        	xtype: 'importusersx-panel-home'
            ,renderTo: 'importusersx-panel-home-div'
        }]
    });
	
    importUsersX.page.Home.superclass.constructor.call(this,config);
	
};

Ext.extend(importUsersX.page.Home,MODx.Component);
Ext.reg('importusersx-page-home',importUsersX.page.Home);