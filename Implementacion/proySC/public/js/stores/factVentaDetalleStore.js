var factVentaDetalleStore = new Ext.data.JsonStore({
	// store configs
	totalProperty: 'numResults',
	//url: baseURL + '/stock/articulo/index',
	// reader configs
	root: '',
	//autoLoad:true,
	idProperty: 'stock_articulo_id',//no pueden haber dos articulos igfuales en la misma compra
	fields: ['fact_egreso_detalle_id','fact_egreso_id','precio_venta_final','stock_articulo_id','cantidad','precio_unit','articulo','porc_impuesto']
});