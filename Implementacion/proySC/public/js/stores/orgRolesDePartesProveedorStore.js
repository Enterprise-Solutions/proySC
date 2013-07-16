

/* Devuelve solo los proveedores */
var orgRolParteStore = new Ext.data.JsonStore({
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
		'p[limit]': 'all',
		'p[page]': 0,
		's[org_rol_codigo]':'proveedor'
	},
	//autoLoad:true,
	idProperty: 'org_parte_rol_id',
	fields: ['org_parte_rol_id',{name:'mostrar', convert:function(v,data){
		var nombre = '';
		if(data.org_parte_tipo_nombre == 'Empresa')
		{
			nombre =  data.nombre;
		}
		else if(data.org_parte_tipo_nombre == 'Persona')
		{
			nombre = data.apellido + ', ' + data.nombre;
		}
		
		var doc = '';
		
		if(data.documentos && data.documentos.length)
		{
			for(var x=0; x<data.documentos.length > 0; x++)
			{
				doc += ((x == 0)?('. Docs: '):(' / ')) + data.documentos[x].org_documento_tipo_codigo + ': ' + data.documentos[x].valor;
			}
		}
		
		return nombre + doc;
	}},{name:'mostrarDocumentos', convert:function(v,data){
		
		var doc = '';
		
		if(data.documentos && data.documentos.length)
		{
			for(var x=0; x<data.documentos.length > 0; x++)
			{
				doc += ((x == 0)?(''):(' / ')) + data.documentos[x].org_documento_tipo_codigo + ': ' + data.documentos[x].valor;
			}
		}
		
		return doc;
	}},{name:'mostrarNombre', convert:function(v,data){
		var nombre = '';
		if(data.org_parte_tipo_nombre == 'Empresa')
		{
			nombre = data.nombre;
		}
		else if(data.org_parte_tipo_nombre == 'Persona')
		{
			nombre = data.apellido + ', ' + data.nombre;
		}
		
		return nombre;
	}},'org_rol_nombre','org_parte_tipo_nombre','documentos','org_parte_id','nombre','apellido','fechaDeNacimiento','genero']
});