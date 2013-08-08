

var stockGarantiaTipoStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/stock/combos/garantia-tipo',
	// reader configs
	root: 'records',
	autoLoad:true,
	idProperty: 'stock_garantia_tipo_id',
	fields: ['stock_garantia_tipo_id','garantia_tipo']
});