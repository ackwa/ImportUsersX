ImportUsersX.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('importusersx')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
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