
var orgRolesDePartesStore = new Ext.data.JsonStore({
	// store configs
	totalProperty: 'numResults',
	url: baseURL + '/org/roles-de-partes/index',
	// reader configs
	root: 'records',
	paramNames: {
		start: 'p[page]',
		limit: 'p[limit]'
	},
	baseParams: {
		'p[limit]': 10,
		'p[page]': 0
	},
	autoLoad:true,
	idProperty: 'org_parte_rol_id',
	fields: ['org_parte_rol_id','org_rol_nombre','org_parte_tipo_nombre','org_parte_id','nombre','apellido','fechaDeNacimiento','genero']
});
