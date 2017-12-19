var vkroulette = function(config) {
	config = config || {};
	vkroulette.superclass.constructor.call(this,config);
};
Ext.extend(vkroulette,Ext.Component,{
	page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}, utils: {}
});
Ext.reg('vkroulette',vkroulette);

vkroulette = new vkroulette();