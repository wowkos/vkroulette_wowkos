vkroulette.grid.members = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		id: 'vkroulette-grid-members'
		,url: vkroulette.config.connector_url
		,baseParams: {
			action: 'mgr/member/getlist'
		}
		,fields: ['id','name','description']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,columns: [
			{header: _('id'),dataIndex: 'id',width: 70}
			,{header: _('name'),dataIndex: 'name',width: 200}
			,{header: _('description'),dataIndex: 'description',width: 250}
		]
		,tbar: [{
			text: _('vkroulette_btn_create')
			,handler: this.createItem
			,scope: this
		}]
		,listeners: {
			rowDblClick: function(grid, rowIndex, e) {
				var row = grid.store.getAt(rowIndex);
				this.updateItem(grid, e, row);
			}
		}
	});
	vkroulette.grid.members.superclass.constructor.call(this,config);
};
Ext.extend(vkroulette.grid.members,MODx.grid.Grid,{
	windows: {}

	,getMenu: function() {
		var m = [];
		m.push({
			text: _('vkroulette_member_update')
			,handler: this.updateItem
		});
		m.push('-');
		m.push({
			text: _('vkroulette_member_remove')
			,handler: this.removeItem
		});
		this.addContextMenuItem(m);
	}
	
	,createItem: function(btn,e) {
		if (!this.windows.createItem) {
			this.windows.createItem = MODx.load({
				xtype: 'vkroulette-window-member-create'
				,listeners: {
					'success': {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.createItem.fp.getForm().reset();
		this.windows.createItem.show(e.target);
	}

	,updateItem: function(btn,e,row) {
		if (typeof(row) != 'undefined') {this.menu.record = row.data;}
		var id = this.menu.record.id;

		MODx.Ajax.request({
			url: vkroulette.config.connector_url
			,params: {
				action: 'mgr/member/get'
				,id: id
			}
			,listeners: {
				success: {fn:function(r) {
					if (!this.windows.updateItem) {
						this.windows.updateItem = MODx.load({
							xtype: 'vkroulette-window-member-update'
							,record: r
							,listeners: {
								'success': {fn:function() { this.refresh(); },scope:this}
							}
						});
					}
					this.windows.updateItem.fp.getForm().reset();
					this.windows.updateItem.fp.getForm().setValues(r.object);
					this.windows.updateItem.show(e.target);
				},scope:this}
			}
		});
	}

	,removeItem: function(btn,e) {
		if (!this.menu.record) return false;
		
		MODx.msg.confirm({
			title: _('vkroulette_member_remove')
			,text: _('vkroulette_member_remove_confirm')
			,url: this.config.url
			,params: {
				action: 'mgr/member/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				'success': {fn:function(r) { this.refresh(); },scope:this}
			}
		});
	}
});
Ext.reg('vkroulette-grid-members',vkroulette.grid.members);




vkroulette.window.CreateItem = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecmember'+Ext.id();
	Ext.applyIf(config,{
		title: _('vkroulette_member_create')
		,id: this.ident
		,height: 200
		,width: 475
		,url: vkroulette.config.connector_url
		,action: 'mgr/member/create'
		,fields: [
			{xtype: 'textfield',fieldLabel: _('name'),name: 'name',id: 'vkroulette-'+this.ident+'-name',anchor: '99%'}
			,{xtype: 'textarea',fieldLabel: _('description'),name: 'description',id: 'vkroulette-'+this.ident+'-description',height: 150,anchor: '99%'}
		]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	vkroulette.window.CreateItem.superclass.constructor.call(this,config);
};
Ext.extend(vkroulette.window.CreateItem,MODx.Window);
Ext.reg('vkroulette-window-member-create',vkroulette.window.CreateItem);


vkroulette.window.UpdateItem = function(config) {
	config = config || {};
	this.ident = config.ident || 'meumember'+Ext.id();
	Ext.applyIf(config,{
		title: _('vkroulette_member_update')
		,id: this.ident
		,height: 200
		,width: 475
		,url: vkroulette.config.connector_url
		,action: 'mgr/member/update'
		,fields: [
			{xtype: 'hidden',name: 'id',id: 'vkroulette-'+this.ident+'-id'}
			,{xtype: 'textfield',fieldLabel: _('name'),name: 'name',id: 'vkroulette-'+this.ident+'-name',anchor: '99%'}
			,{xtype: 'textarea',fieldLabel: _('description'),name: 'description',id: 'vkroulette-'+this.ident+'-description',height: 150,anchor: '99%'}
		]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	vkroulette.window.UpdateItem.superclass.constructor.call(this,config);
};
Ext.extend(vkroulette.window.UpdateItem,MODx.Window);
Ext.reg('vkroulette-window-member-update',vkroulette.window.UpdateItem);