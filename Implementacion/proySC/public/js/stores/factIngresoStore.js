
var factIngresoStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/fact/compra/index',
	// reader configs
	root: 'records',
	autoLoad:true,
	paramNames: {
		start: 'p[page]',
		limit: 'p[limit]'
	},
	totalProperty: 'numResults',
	idProperty: 'fact_ingreso_id',
	fields: ['fact_ingreso_id','cont_moneda_id','codigo','doc_nro','doc_fecha','doc_tipo','condicion','estado','total_excenta','total_iva_cinco_porciento','total_iva_diez_porciento','total_ingreso','moneda','moneda_simbolo']
});