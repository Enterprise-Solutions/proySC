
function formularioPersona(isNew, data)
{
	return {
		xtype: 'container',
		layout: 'form',
		autoHeight: true,
		items:[
				{
			       xtype: 'hidden',
			       name: 'org_parte_id',
			       value: (isNew)?(null):(data.org_parte_id)
		       },
		       {
			       fieldLabel: 'Apellido',
			       name: 'apellido',
			       value: (isNew)?(null):(data.apellido_persona),
			       xtype: 'textfield',
			       allowBlank: false
		       },
		       {
			       fieldLabel: 'Nombre',
			       name: 'nombre',
			       value: (isNew)?(null):(data.nombre_persona),
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
		       },
		       {
			       fieldLabel: 'Fecha Nac.',
			       name: 'fecha_nac',
			       format: 'd/m/Y',
			       value: (isNew)?(null):(data.fecha_nacimiento),
			       xtype: 'datefield'
		       },
		       {
			       fieldLabel: 'Genero',
			       xtype: 'radiogroup',
			       name: 'checkBoxGr',
			       allowBlank: false,
			       columns: 2,
			       items: [
			               {boxLabel: 'Hombre', name: 'genero_persona', inputValue: 'H', checked: (isNew)?(false):( (data.genero_persona == 'H')?(true):(false) )},
			               {boxLabel: 'Mujer', name: 'genero_persona', inputValue: 'M', checked: (isNew)?(false):( (data.genero_persona == 'M')?(true):(false) )}
			       ]
		       }
		       
		]
	};	
}

