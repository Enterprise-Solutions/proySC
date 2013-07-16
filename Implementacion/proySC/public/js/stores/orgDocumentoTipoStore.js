var orgDocumentoTipoStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/org/combos/org-documento-tipo',
	// reader configs
	autoLoad:true,
	root: 'records',
	idProperty: 'org_documento_tipo_codigo',
	fields: ['org_documento_tipo_codigo','nombre','descripcion']
});