Ext.onReady(function() {
    MODx.load({ xtype: 'importusersx-page-home'});
});
 
ImportUsersX.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'importusersx-panel-home'
            ,renderTo: 'importusersx-panel-home-div'
        }]
    });
    ImportUsersX.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(ImportUsersx.page.Home,MODx.Component);
Ext.reg('importusersx-page-home',ImportUsersX.page.Home);