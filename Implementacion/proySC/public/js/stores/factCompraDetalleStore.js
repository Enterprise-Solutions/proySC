var factCompraDetalleStore = new Ext.data.JsonStore({
	// store configs
	totalProperty: 'numResults',
	//url: baseURL + '/stock/articulo/index',
	// reader configs
	root: '',
	//autoLoad:true,
	idProperty: 'fact_compra_detalle_id',
	fields: ['fact_compra_detalle_id','fact_compra_id','stock_articulo_id','cantidad','costo_unit','nombre','impuesto']
});