var factCompraDetalleStore = new Ext.data.JsonStore({
	// store configs
	totalProperty: 'numResults',
	//url: baseURL + '/stock/articulo/index',
	// reader configs
	root: '',
	//autoLoad:true,
	idProperty: 'stock_articulo_id',//no pueden haber dos articulos igfuales en la misma compra
	fields: ['fact_ingreso_detalle_id','fact_ingreso_id','stock_articulo_id','cantidad','costo_unit','articulo','porc_impuesto']
});