


var orgRolStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/org/combos/org-rol',
	// reader configs
	autoLoad:true,
	root: 'records',
	idProperty: 'org_rol_codigo',
	fields: ['org_rol_codigo','descripcion','nombre']
});