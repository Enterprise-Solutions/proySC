
function formularioEmpresa(isNew, data)
{
	return {
		xtype: 'container',
		layout: 'form',
		autoHeight: true,
		items:[
				{
			       xtype: 'hidden',
			       name: 'org_parte_id',
			       value: (isNew)?(null):(data.data)
		       },
		       {
			       fieldLabel: 'Nombre',
			       name: 'nombre',
			       value: (isNew)?(null):(data.nombre),
			       xtype: 'textfield',
			       allowBlank: false
		       },
		       {
		           xtype: 'fieldset',
		           title: 'Documento',
		           labelWidth: 75,
		           items:[
		           			{
		           				xtype: 'textfield',
		           				name: 'valor',
		           				value: (isNew)?(null):(data.valor),
		           				allowBlank: false,
		           				fieldLabel: 'Numero'
		           			},
		           			{
		           				xtype: 'combo',
		           				forceSelection: true,
		           				mode: 'local',
		           				value: (isNew)?(null):(data.org_documento_tipo_codigo),
		           				typeAhead: true,
		           				displayField: 'nombre',
		           				valueField: 'org_documento_tipo_codigo',
		           				store: orgDocumentoTipoStore,
		           				allowBlank: false,
		           				hiddenName: 'org_documento_tipo_codigo',
		           				fieldLabel: 'Tipo'
		           			}
		           ]
		       }
		]
	};	
}