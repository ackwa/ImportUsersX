var ImportUsersX = function(config) {
    config = config || {};
    ImportUsersX.superclass.constructor.call(this,config);
};
Ext.extend(ImportUsersX,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('importusersx',ImportUsersX);
ImportUsersX = new ImportUsersX();