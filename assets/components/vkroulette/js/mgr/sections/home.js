vkroulette.page.Home = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		components: [{
			xtype: 'vkroulette-panel-home'
			,renderTo: 'vkroulette-panel-home-div'
		}]
	}); 
	vkroulette.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(vkroulette.page.Home,MODx.Component);
Ext.reg('vkroulette-page-home',vkroulette.page.Home);