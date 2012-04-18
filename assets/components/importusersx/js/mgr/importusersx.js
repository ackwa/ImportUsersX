var importUsersX = function(config) {
	
    config = config || {};
    importUsersX.superclass.constructor.call(this,config);
};

Ext.extend(importUsersX,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});

Ext.reg('importusersx',importUsersX);
importUsersX = new importUsersX();