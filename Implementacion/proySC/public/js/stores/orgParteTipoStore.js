
var orgParteTipoStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/org/combos/org-parte-tipo',
	// reader configs
	autoLoad:true,
	root: 'records',
	idProperty: 'org_parte_tipo_codigo',
	fields: ['org_parte_tipo_codigo','descripcion','nombre']
});