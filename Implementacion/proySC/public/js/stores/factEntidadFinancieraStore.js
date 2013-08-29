var factEntidadFinancieraStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/fact/entidad-financiera/index',
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
	idProperty: 'fact_entidad_financiera_id',
	fields: ['fact_entidad_financiera_id','nombre']
});