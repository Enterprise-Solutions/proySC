var factTarjetaTipoStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/fact/tarjeta-tipo/index',
	// reader configs
	root: 'records',
	autoLoad:true,
	baseParams: {
		'p[limit]': 10,
		'p[page]': 0
	},
	paramNames: {
		start: 'p[page]',
		limit: 'p[limit]'
	},
	idProperty: 'fact_tarjeta_tipo_id',
	fields: ['fact_tarjeta_tipo_id','nombre']
});