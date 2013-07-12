
var stockMonedaStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/cont/moneda/index',
	// reader configs
	root: 'records',
	autoLoad:true,
	baseParams: {
		'p[limit]': 'all'
	},
	idProperty: 'cont_moneda_id',
	fields: ['cont_moneda_id','moneda','simbolo']
});