/*
 * Depende de:
 *     /stores/genericoProductoStore.js
 * */

function formularioStockArticulo(isNew, data, readOnly, isOnModalWindow, cb)
{
	return {
		xtype: 'form',
		title: (readOnly)?('Ver Articulo'):((isNew)?('Crear Articulo'):('Editar Articulo')),
		cls: 'ladoDerecho',
		bodyCssClass: 'formularioGeneral',
		layout: 'form',
		//defaults:{(readOnly)?(xtype:'displayfield'):(xtype:'textfield')},
		autoHeight: true,
		items:[
		       {
			       xtype: 'hidden',
			       name: 'stock_articulo_id',
			       value: (isNew)?(null):(data.stock_articulo_id)
		       },
		       {
			       fieldLabel: 'Nombre',
			       name: 'nombre',
			       width: 150,
			       maxLength: 40,
			       value: (isNew)?(null):(data.nombre),
			       xtype: 'textfield',
			       disabled:readOnly,
			       allowBlank: false
		       },
		       {
			       fieldLabel: 'Codigo',
			       name: 'codigo',
			       width: 115,
			       maxLength: 40,
			       value: (isNew)?(null):(data.codigo),
			       xtype: 'textfield',
			       disabled:readOnly,
			       allowBlank: false
		       },
		       {
			       fieldLabel: 'Modelo',
			       name: 'modelo',
			       maxLength: 100,
			       width: 150,
			       value: (isNew)?(null):(data.modelo),
			       xtype: 'textfield',
			       disabled:readOnly,
			       allowBlank: false
		       },
		       {
			       	fieldLabel: 'Marca',
			        hiddenName: 'stock_marca_id',
			       	width: 130,
			       	valueField: 'stock_marca_id',
			       	forceSelection: true,
			       	displayField:'marca',
			       	value: (isNew)?(null):(data.stock_marca_id),
			       	xtype: 'combo',
			       	disabled:readOnly,
			       	store: stockMarcaStore,
			       	typeAhead:true,mode:'local',
			       	allowBlank: false,
			       	listeners:{
			       		'render':function(thisEl){
			       			if(readOnly)
			       				return;
			       				
			       			//contenedor
			       			var itemContainer = thisEl.itemCt.dom.childNodes[1].firstChild.id;
			       			
			       			//en el de arriba tengo que insertar mi boton
			       			var contenedor = Ext.get(itemContainer);
			       			
			       			var nuevoEl = document.createElement('button');
			       			nuevoEl.innerHTML = '+';
			       			nuevoEl.setAttribute('style','margin-left:25px;position:absolute;top:-3px;');
			       			
			       			console.log('nuevoEl',nuevoEl);
			       			
			       			contenedor.appendChild(nuevoEl, 'after');
			       			
			       		}
			       	}
		       },
		       {
			       	fieldLabel: 'Categoria',
			        hiddenName: 'stock_categoria_id',
			       	width: 130,
			       	valueField: 'stock_categoria_id',
			       	displayField:'categoria',
			       	forceSelection: true,
			       	disabled:readOnly,
			       	value: (isNew)?(null):(data.stock_categoria_id),
			       	xtype: 'combo',
			       	store: stockCategoriaStore,
			       	typeAhead:true,mode:'local',
			       	allowBlank: false,
			       	listeners:{
			       		'render':function(thisEl){
			       			console.log('thisEl',thisEl);
			       			//contenedor
			       			var itemContainer = thisEl.itemCt.dom.childNodes[1].firstChild.id;
			       			
			       			//en el de arriba tengo que insertar mi boton
			       			var contenedor = Ext.get(itemContainer);
			       			
			       			//var destino = contenedor.dom.childNodes[1];
			       			
			       			//var auxiliar = Ext.get(destino.id);
			       			
			       			var nuevoEl = document.createElement('button');
			       			nuevoEl.innerHTML = '+';
			       			nuevoEl.setAttribute('style','margin-left:25px;position:absolute;top:-3px;');
			       			nuevoEl.setAttribute('onclick','verArticulo(1);');
			       			
			       			console.log('nuevoEl',nuevoEl);
			       			
			       			contenedor.appendChild(nuevoEl, 'after');
			       		}
			       	}
		       },
		       {
			       fieldLabel: 'NCM',
			       name: 'ncm',
			       maxLength: 100,
			       width: 150,
			       value: (isNew)?(null):(data.ncm),
			       xtype: 'textfield',
			       disabled:readOnly
		       },
		       {
			       fieldLabel: 'Descrip.',
			       name: 'descripcion',
			       disabled:readOnly,
			       width: '80%',
			       value: (isNew)?(null):(data.descripcion),
			       xtype: 'textarea'
		       },
		       {
		           xtype: 'fieldset',
		           title: 'Precio Venta',
		           layout: 'column',
		           defaults:{xtype:'container'},
		           items:[
		           			{
		           				width: 200,
		           				layout: 'form',
		           				labelWidth: 100,
		           				items:[
		       							{
			       							fieldLabel: 'Precio Venta',
			       							name: 'precio_venta',
			       							width: 80,
			       							disabled:readOnly,
			       							value: (isNew)?(null):(data.precio_venta),
			       							xtype: 'numberfield',
			      							allowBlank: false,
			      							allowDecimals:true,
			      							allowNegative: false
		       							}
		           				]
		           			},
		           			{
		           				width: 150,
		           				layout: 'form',
		           				labelWidth: 60,
		           				items:[
		           						{
			       							hideLabel:true,
			       							hiddenName: 'cont_moneda_id',
			       							width: 90,
			       							valueField: 'cont_moneda_id',
			       							forceSelection: true,
			       							displayField:'simbolo',
			       							value: (isNew)?(null):(data.cont_moneda_id),
			       							xtype: 'combo',
			       							disabled:readOnly,
			       							store: stockMonedaStore,
			       							typeAhead:true,
			       							mode:'local',
			       							allowBlank: false
		       							}
		           				]
		           			}
		           ]
		       },
		       {
		           xtype: 'fieldset',
		           title: 'Garantia',
		           layout: 'column',
		           defaults:{xtype:'container'},
		           items:[
		           			{
		           				width: 150,
		           				layout: 'form',
		           				labelWidth: 80,
		           				items:[
		           						{
			       							fieldLabel: 'Tiempo Gar.',
			       							name: 'tiempo_garantia',
			       							width: 50,
			       							value: (isNew)?(null):(data.tiempo_garantia),
			       							xtype: 'numberfield',
			       							allowBlank: false,
			       							allowNegative:false,
			       							forceSelection: true,
			       							disabled:readOnly,
			       							allowDecimals: false
		       							}
		           				]
		           			},
		           			{
		           				width: 150,
		           				layout: 'form',
		           				labelWidth: 60,
		           				items:[
		           						{
			       							hideLabel:true,
			       							hiddenName: 'stock_garantia_tipo_id',
			       							width: 90,
			       							valueField: 'stock_garantia_tipo_id',
			       							displayField:'garantia_tipo',
			       							value: (isNew)?(null):(data.stock_garantia_tipo_id),
			       							xtype: 'combo',
			       							disabled:readOnly,
			       							store: stockGarantiaTipoStore,
			       							typeAhead:true,mode:'local',
			       							allowBlank: false
		       							}
		           				]
		           			}
		           ]
		       },
		       {
			       fieldLabel: '%IVA',
			       hiddenName: 'porcentaje_impuesto',
			       value: (isNew)?(10):(data.porcentaje_impuesto),
			       xtype: 'combo',
			       forceSelection: true,
			       triggerAction: 'all',
			       store: stockImpuestoStore,
			       displayField: 'valor',
			       disabled:readOnly,
			       valueField: 'id',
			       mode: 'local',
			       width: 100,
			       allowBlank: false
		       },
		       {
			       fieldLabel: '% Max. Desc.',
			       name: 'descuento_maximo',
			       value: (isNew)?(0):(data.descuento_maximo),
			       xtype: 'numberfield',
			       disabled:readOnly,
			       width: 45,
			       allowNegative: false,
			       allowBlank: false
		       },
		       {
			       fieldLabel: 'Estado',
			       hiddenName: 'estado',
			       value: (isNew)?('A'):(data.estado),
			       xtype: 'combo',
			       store: stockEstadoStore,
			       displayField: 'valor',
			       valueField: 'id',
			       disabled:readOnly,
			       mode: 'local',
			       triggerAction: 'all',
			       width: 100,
			       allowBlank: false
		       },
		       {
		           xtype: 'numberfield',
		           fieldLabel: 'Exist. Min.',
		           width: 75,
		           allowBlank: false,
		           name: 'existencia_minima',
		           value: (isNew)?(0):(data.existencia_minima),
		           disabled:readOnly,
		       },
		       {
		           xtype: 'textfield',
		           fieldLabel: 'RCAP',
		           width: 200,
		           maxLength: 100,
		           name: 'rcap',
		           value: (isNew)?(null):(data.rcap),
		           disabled:readOnly,
		       },
		       {
			       fieldLabel: 'Tipo',
			       hiddenName: 'tipo',
			       value: (isNew)?('P'):(data.tipo),
			       xtype: 'combo',
			       store: genericoProductoStore,
			       displayField: 'valor',
			       valueField: 'id',
			       disabled:readOnly,
			       mode: 'local',
			       forceSelection: true,
			       triggerAction: 'all',
			       width: 75,
			       allowBlank: false
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
									       
							
									       if(valores.stock_articulo_id)//si existe es edicion
									       {
									    	   Ajax.PostElement.request({
												   url: baseURL + '/stock/articulo/put',
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
												   jsonData:{
												       'put': valores,
													   'formulario': mainForm.id
												   }
											   });
									       }
									       else
									       {
									           delete valores.stock_articulo_id;
									           
										       //sino es creacion
									    	   //si esta todo ok hacemos la solicitud
									    	   Ajax.PostElement.request({
												   url: baseURL + '/stock/articulo/post',
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
												   jsonData:{
												       'post': valores,
													   'formulario': mainForm.id
												   }
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
		],
		listeners:{
			'render':function(thisEl){
				hideBloque();
			}
		}
	};	
}