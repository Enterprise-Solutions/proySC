var factTarjetaNombreStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/fact/tarjeta-nombre/index',
	// reader configs
	root: 'records',
	autoLoad:true,
	baseParams: {
		'p[limit]': 10,
		'p[page]': 0
	},
	totalProperty: 'numResults',
	paramNames: {
		start: 'p[page]',
		limit: 'p[limit]'
	},
	idProperty: 'fact_tarjeta_nombre_id',
	fields: ['fact_tarjeta_nombre_id','nombre']
});