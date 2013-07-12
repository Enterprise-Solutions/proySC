var stockMarcaStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/stock/combos/marca',
	// reader configs
	root: 'records',
	autoLoad:true,
	idProperty: 'stock_marca_id',
	fields: ['stock_marca_id','marca']
});