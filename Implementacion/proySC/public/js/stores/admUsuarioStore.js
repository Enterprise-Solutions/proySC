
var admUsuarioStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/adm/usuario/index',
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
	totalProperty: 'numResults',
	idProperty: 'adm_usuario_id',
	fields: ['adm_usuario_id','nombre','apellido','documento_identidad','estado','estado_usuario','roles']
});