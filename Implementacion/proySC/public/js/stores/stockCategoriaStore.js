
var stockCategoriaStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/stock/combos/categoria',
	// reader configs
	autoLoad:true,
	root: 'records',
	idProperty: 'stock_categoria_id',
	fields: ['stock_categoria_id','categoria']
});