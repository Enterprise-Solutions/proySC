
var admPersonasDisponiblesStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/adm/usuario/personas-disponibles',
	// reader configs
	root: 'records',
	autoLoad:true,
	baseParams: {
		'p[limit]': 'all'
	},
	totalProperty: 'numResults',
	idProperty: 'org_parte_id',
	fields: ['org_parte_id','nombre','apellido','documento_identidad',{name: 'mostrar', convert: function(v,data){
		return data.apellido + ', ' + data.nombre + ' / ' + data.documento_identidad;
		}}
	]
});