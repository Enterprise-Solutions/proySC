var stockArticuloStore = new Ext.data.JsonStore({
	// store configs
	totalProperty: 'numResults',
	url: baseURL + '/stock/articulo/index',
	// reader configs
	root: 'records',
	paramNames: {
		start: 'p[page]',
		limit: 'p[limit]'
	},
	baseParams: {
		'p[limit]': 'all',
		'p[page]': 0
	},
	idProperty: 'stock_articulo_id',
	fields: ['stock_articulo_id',{name: 'mostrar', convert:function(v,data){
		return data.nombre + ' / ' + data.codigo;
	}},'rcap','categoria','codigo','existencia','marca','precio_venta_final','porcentaje_impuesto','nombre','precio_venta','moneda','simbolo']
});