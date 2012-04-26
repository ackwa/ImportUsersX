/*
 * ImportUsersX :: index.js
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