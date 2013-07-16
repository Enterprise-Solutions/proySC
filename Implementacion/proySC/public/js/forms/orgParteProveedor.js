/*
 * Depende de:
 *     /stores/genericoProductoStore.js
 *     Solo crear proveedores / hardcoded
 * */

function formularioOrgParte(isNew, data, readOnly, isOnModalWindow, cb)
{
	console.log('formularioOrgParte',isNew, data, readOnly, isOnModalWindow, cb);
	return {
		xtype: 'container',
		layout: 'anchor',
		items:[
				{
					xtype: 'form',
					title: 'Asignar Rol a Parte',
					cls: 'ladoDerecho',
					bodyCssClass: 'formularioGeneral',
					layout: 'form',
					autoHeight: true,
					items:[
							{
								xtype: 'combo',
								fieldLabel: 'Nombre / Doc.',
								hideTrigger: true,
								width: 200,
								allowBlank: false,
								minChars: 3,
								cls: 'searchIcon',
								displayField: 'mostrar',
								valueField: 'org_parte_id',
								forceSelection: true,
								mode: 'remote',
								triggerAction: 'all',
								listWidth: 350,
								queryDelay: 1500,
								queryParam: 's[nombre]',
								store: orgParteStore,
								hiddenName: 'org_parte_id_buscar'
							},
							{
								xtype: 'hidden',
								name: 'org_rol_codigo_buscar',
								value: 'proveedor'
							},
							{
			       				xtype: 'container',
			       				layout: 'column',
			       				defaults:{style: {margin: '5px'}},
			       				items:[
										{
							    			xtype: 'button',
							    			text: 'Guardar',
							    			handler: function(b,e)
							    			{
								       			//verificar si esta todo ok
								       			var mainForm = b.ownerCt.ownerCt;
								       			basicForm = mainForm.getForm();
								       			if(basicForm.isValid())
								       			{
									       			var valores = basicForm.getFieldValues();

													var parteId = valores.org_parte_id_buscar;
											
													delete valores.org_parte_id_buscar;
											
													if(parteId)//si la parte ya existe es la unica forma que entre aca sino no es valido
													{
														Ajax.PostElement.request({
												   			url: baseURL + '/org/roles-de-partes/crear',
												   			success: function(response, opt){
												   				if(!isOnModalWindow)
												   					mainStore.reload();
												   				else
											   					{
												   					ventanaModal.hide();
																	if(cb)
																	   cb(true, response);
											   					}
												   			},
												   			jsonData: {
												   				'post':{
												   					org_rol_codigo: valores.org_rol_codigo_buscar,
												   					org_parte: {
												   						org_parte_id: parteId
												   					}
												   				},
												   				'formulario': mainForm.id
												   			}
											   			});
													}
								       			}//end of if
								       			else
									   			{
										   			Ext.Msg.alert('Aviso','Hay campos inv&aacute;lidos');
									   			}       
								   	   		}//end of handler
										},//end of button 1
										{
											xtype: 'button',
											text: 'Cancelar',
											handler: function(b,e){
												if(isOnModalWindow)
												{
													ventanaModal.hide();
													if(cb)
														cb(false, data);
												}
												else
												{
													var mainForm = b.ownerCt.ownerCt;
								        			var padre = mainForm.ownerCt;
								        			padre.remove(mainForm);
												}
												
											}//end of handler
										}//end of button 2
				   				]
		       				}
					]
				},
				{
					xtype: 'form',
					title: (readOnly)?('Ver Parte'):((isNew)?('Agregar Parte'):('Editar Parte')),
					cls: 'ladoDerecho',
					bodyCssClass: 'formularioGeneral',
					layout: 'form',
					autoHeight: true,
					items:[
							{
								xtype: 'hidden',
								name: 'org_rol_codigo',
								value: 'proveedor'
							},
							{
								xtype: 'combo',
								fieldLabel: 'Tipo',
								allowBlank: false,
								width: 125,
								displayField: 'nombre',
								valueField: 'org_parte_tipo_codigo',
								forceSelection: true,
								mode: 'local',
								store: orgParteTipoStore,
								name: 'org_parte_tipo_codigo',
								listeners:{
						'select':function(thisCombo, record, index)
						{
							var padre = thisCombo.ownerCt;
							var destino = padre.find('itemId','bloqueDinamico');
							if(destino.length > 0)
							{
								destino = destino[0];
								
								destino.removeAll();
								
								if(record.id == 'org')
								{
									destino.add(formularioEmpresa(true, null));
								
									destino.doLayout();
								}
								else if(record.id == 'per')
								{
									destino.add(formularioPersona(true, null));
								
									destino.doLayout();
								}
								
							}
						}
					}
				},
				{
					xtype: 'container',
					layout: 'form',
					itemId: 'bloqueDinamico'
				},  
		       {
			       xtype: 'container',
			       layout: 'column',
			       defaults:{style: {margin: '5px'}},
			       items:[
							{
							    xtype: 'button',
							    text: 'Guardar',
							    handler: function(b,e){
								       //verificar si esta todo ok
								       var mainForm = b.ownerCt.ownerCt;
								       basicForm = mainForm.getForm();
								       if(basicForm.isValid())
								       {
									       var valores = basicForm.getFieldValues();

											var parteId = valores.org_parte_id;
											
											delete valores.org_parte_id;
											
											if(parteId)//si la parte ya existe
											{
												if(valores.org_parte_tipo_codigo == 'org')
												{
												}
											}
											else//si la parte NO existe creo la parte
											{
												var datos = {};
												
												if(valores.org_parte_tipo_codigo == 'org')//de tipo empresa
												{
													datos = {post:{
														org_rol_codigo: valores.org_rol_codigo,
														org_parte: {
															org_parte_id: null,
															org_parte_tipo_codigo: valores.org_parte_tipo_codigo,
															nombre: valores.nombre,
															Documentos:{
																agregados: [
																	{
																		org_documento_tipo_codigo: valores.org_documento_tipo_codigo,
																		valor: valores.valor
																	}
																]
															}
														}
													},
														'formulario': mainForm.id													
													};
												}
												else if(valores.org_parte_tipo_codigo == 'per')//de tipo persona
												{
													datos = {post:{
														org_rol_codigo: valores.org_rol_codigo,
														org_parte: {
															org_parte_id: null,
															org_parte_tipo_codigo: valores.org_parte_tipo_codigo,
															nombre: valores.nombre,
															apellido: valores.apellido,
															fechaDeNacimiento: (formatearFecha(valores.fecha_nac, 1)),
															genero: valores.checkBoxGr.inputValue,
															Documentos: {
																agregados: [
																	{
																		org_documento_tipo_codigo: valores.org_documento_tipo_codigo,
																		valor: valores.valor
																	}
																]
															}
														}
													},
														'formulario': mainForm.id
													};
												}
												
												
												Ajax.PostElement.request({
												   		url: baseURL + '/org/roles-de-partes/crear',
												   		success: function(response, opt){
												   			if(!isOnModalWindow)
														       mainStore.reload();
														   else	
														   {
															   ventanaModal.hide();
															   if(cb)
																   cb(true, response);
														   }
												   		},
												   		jsonData:datos
											   		});
											}
											
									       
								       }
								       else
									   {
										   Ext.Msg.alert('Aviso','Hay campos inv&aacute;lidos');
									   }       
								   }
							},
							{
								xtype: 'button',
								text: 'Cancelar',
								handler: function(b,e){
									if(isOnModalWindow)
									{
										ventanaModal.hide();
										if(cb)
											cb(false, data);
									}
									else
									{
										var mainForm = b.ownerCt.ownerCt;
					        			var padre = mainForm.ownerCt;
					        			padre.remove(mainForm);
									}
								}
							}
				   ]
		       }
				]
			}
		],//end of items del contenedor principal
		listeners:{
			'render':function(){
				hideBloque();
			}
		}//end of listeners del contenedor principal
	};//end of container
}