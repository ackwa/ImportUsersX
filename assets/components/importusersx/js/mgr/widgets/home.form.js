/*
 * importUsersX
 *
 * Copyright 2011 by Mark Hamstra (http://www.markhamstra.nl)
 * Development funded by Working Party, a Sydney based digital agency.
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
var topic = '/importusersx/';
var register = 'mgr';
importUsersX.page.createImport = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        formpanel: 'importusersx-form-create-import'
        ,buttons: [{
            process: 'import',
            text: _('importusersx.startbutton'), 
            handler: function() {
                if (this.console == null || this.console == undefined) {
                    this.console = MODx.load({
                       xtype: 'modx-console'
                       ,register: register
                       ,topic: topic
                       ,show_filename: 0
                       ,listeners: {
                         'shutdown': {fn:function() {
                             Ext.getCmp('modx-layout').refreshTrees();
                         },scope:this}
                       }
                    });
                } else {
                    this.console.setRegister(register, topic);
                }
                this.console.show(Ext.getBody());
                Ext.getCmp('importusersx-panel-import').form.submit({
                    success:{fn:function() {
                        this.console.fireEvent('complete');
                    },scope:this},
                    failure: function(f, a) {
                        //alert(_('importusersx.importfailure')+' '+a.result.message);
                        //console.fireEvent('complete');
                    }
                });
            }
        },'-',{
            text: _('help_ex'),
            handler: MODx.loadHelpPane
        }]
        ,components: [{
            xtype: 'importusersx-form-create-import'
        }]
    });
    importUsersX.page.createImport.superclass.constructor.call(this,config);
};
Ext.extend(importUsersX.page.createImport,MODx.Component);
Ext.reg('importusersx-page-import',importUsersX.page.createImport);



importUsersX.panel.createImport = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: importUsersX.config.connectorUrl
        ,baseParams: {
            action: 'startimport',
            register: register,
            topic: topic
        }
        ,layout: 'fit'
        ,id: 'importusersx-panel-import'
        ,buttonAlign: 'center'
        ,fileUpload: true
        ,width: '98%'
        ,items: [{
            border: true
            ,labelWidth: 150
            ,autoHeight: true
            ,buttonAlign: 'center'
            ,items: [{
                html: '<p>'+_('importusersx.desc')+'</p>',
                border: false,
                bodyCssClass: 'panel-desc'
            },{
                xtype: 'modx-tabs',
                cls: 'main-wrapper',
                deferredRender: false,
                forceLayout: true,
                defaults: {
                    layout: 'form',
                    autoHeight: true,
                    hideMode: 'offsets',
                    padding: 15
                },
                items: [{
                    xtype: 'modx-panel',
                    title: _('importusersx.tab.input'),
                    items: [{
                        html: '<p>'+_('importusersx.tab.input.desc')+'</p>',
                        border: false
                    },{
                        xtype: 'textarea',
                        fieldLabel: _('importusersx.csv'), 
                        name: 'csv',
                        id: 'importusersx-import-csv',
                        labelSeparator: '',
                        anchor: '100%',
                        height: 150,
                        allowBlank: false,
                        blankText: _('importusersx.nocsv')
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('importusersx.csvfile'),
                        name: 'csv-file',
                        id: 'csv-file',
                        inputType: 'file'
                    },{
                        html: '<p>'+_('importusersx.tab.input.sep')+'</p>',
                        border: false
                    },{
                        xtype: 'textfield',
                        fieldLabel: _('importusersx.separator'),
                        name:  'separator',
                        id: 'importusersx-import-sep',
                        anchor: '100%',
                        allowBlank: true
                    }]
                },{
                    title: _('importusersx.tab.settings'),
                    id: 'importusersx-defaults',                    
                    items: [{
                        html: '<p>'+_('importusersx.tab.settings.desc')+'</p>'
                        ,border: false
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('importusersx.parent')
                        ,name: 'parent'
                        ,id: 'importusersx-import-parent'
                        ,labelSeparator: ''
                        ,anchor: '100%'
                        ,value: 0
                        ,allowBlank: false
                        ,blankText: _('importusersx.noparent')
                    },{
                        xtype: 'checkbox',
                        fieldLabel: _('resource_published'),
                        name: 'published',
                        id: 'importusersx-import-published',
                        anchor: '100%',
                        checked: importUsersX.defaults['published']
                    },{
                        xtype: 'checkbox',
                        fieldLabel: _('resource_searchable'),
                        name: 'searchable',
                        id: 'importusersx-import-searchable',
                        anchor: '100%',
                        checked: importUsersX.defaults['searchable']
                    },{
                        xtype: 'checkbox',
                        fieldLabel: _('resource_hide_from_menus'),
                        name: 'hidemenu',
                        id: 'importusersx-import-hidemenu',
                        anchor: '100%',
                        checked: importUsersX.defaults['hidemenu']
                    }]
                }]
            }]
        }]
    });
    Ext.Ajax.timeout = 0;
    importUsersX.panel.createImport.superclass.constructor.call(this,config);
};
Ext.extend(importUsersX.panel.createImport,MODx.FormPanel);
Ext.reg('importusersx-form-create-import',importUsersX.panel.createImport);
