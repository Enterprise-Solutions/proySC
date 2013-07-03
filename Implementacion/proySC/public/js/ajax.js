Ext.ns('Ajax');

function removeClass(elemento)
{
	elemento.removeClass(['okBox','errorBox','processBox']);
}

Ajax.PostElement = new Ext.data.Connection();

Ajax.PostElement.on('beforerequest', function(conn, options){
	console.log('beforerequest', conn, options);
	//oculto caja de mensaje
	var cajaMensaje = Ext.getCmp('messageBox');
	if(cajaMensaje){
		var hijo = cajaMensaje.items.items[0];
		console.log(cajaMensaje, hijo);
		
		cajaMensaje.addClass('oculto');
		
		//sacamos cualquier mensaje que pueda tener
		hijo.update('Enviando .. ');
		
		//sacamos las otras clases
		removeClass(hijo.el);
		
		//agregamos clase que nos interesa
		hijo.el.addClass('processBox');
		
		//vamos hasta ahi
		//mostramos
		cajaMensaje.removeClass('oculto');
		
	}
});


Ajax.PostElement.on('requestcomplete', function(conn, response, options){
	console.log('requestcomplete', conn, response, options);
	var cajaMensaje = Ext.getCmp('messageBox');
	if(cajaMensaje){
		var hijo = cajaMensaje.items.items[0];
		
		cajaMensaje.addClass('oculto');
		//sacamos cualquier mensaje que pueda tener
		hijo.update('Operacion Exitosa');
		
		//sacamos las otras clases
		removeClass(hijo.el);
		
		//agregamos clase que nos interesa
		hijo.el.addClass('okBox');
		
		//vamos hasta ahi
		//mostramos
		cajaMensaje.removeClass('oculto');
	}
	
	//aca procesamo el formulario si tiene el id
	var formularioId;
	if(options.jsonData)
		formularioId = options.jsonData.formulario;
	
	if(formularioId){
		
		var form = Ext.getCmp(formularioId);
		console.log(form,'form');
		if(form){
			form.ownerCt.remove(form);
		}
	}
});

Ajax.PostElement.on('requestexception', function(conn, response, options){
	console.log('requestexception', conn, response, options);
	var cajaMensaje = Ext.getCmp('messageBox');
	if(cajaMensaje){
		var hijo = cajaMensaje.items.items[0];
		
		cajaMensaje.addClass('oculto');
		//sacamos cualquier mensaje que pueda tener
		hijo.update('Ocurrio un error');
		
		//sacamos las otras clases
		removeClass(hijo.el);
		
		//agregamos clase que nos interesa
		hijo.el.addClass('errorBox');
		
		//vamos hasta ahi
		//mostramos
		cajaMensaje.removeClass('oculto');
	}
});