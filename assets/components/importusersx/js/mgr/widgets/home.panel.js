ImportUsersX.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2> ImportUsersX</h2>'
            ,border: false
            ,cls: 'panel-desc'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('importusersx')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('importusersx.component_desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                }/*,{
                    xtype: 'doodles-grid-doodles'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }*/]
            }]
        }]
    });
    ImportUsersX.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(ImportUsersX.panel.Home,MODx.Panel);
Ext.reg('importusersx-panel-home',ImportUsersX.panel.Home);