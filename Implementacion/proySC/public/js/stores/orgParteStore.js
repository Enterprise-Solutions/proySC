

var orgParteStore = new Ext.data.JsonStore({
	// store configs
	url: baseURL + '/org/parte/index',
	// reader configs
	//autoLoad:true,
	root: 'records',
	idProperty: 'org_parte_id',
	fields: ['org_parte_id','org_parte_tipo_codigo','nombre_persona','apellido_persona','nombre_organizacion','org_parte_tipo_nombre','documentos',
		{name: 'mostrar', convert: function(v,data){
			var doc = '';
			
			if(data.documentos && data.documentos.length > 0)
			{
				for(var x=0; x<data.documentos.length; x++)
				{
					doc += (((x == 0)?(''):(' / ')) + data.documentos[x].org_documento_tipo_codigo + ':' + data.documentos[x].valor);
				}
			}
			
			if(data.org_parte_tipo_codigo == 'per')
			{
				return 'Per: ' + data.apellido_persona + ', ' + data.nombre_persona + ' - ' + doc;
			}
			else if(data.org_parte_tipo_codigo == 'org')
			{
				return 'Emp: ' + data.nombre_organizacion + ' - ' + doc;
			}
		}}]
});