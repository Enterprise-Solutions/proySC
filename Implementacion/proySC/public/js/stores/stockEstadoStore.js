
var stockEstadoStore = new Ext.data.ArrayStore({
	idIndex: 0,  
    fields: ['id','valor'],
    data: [
    	['A','Activo'],
    	['I','Inactivo'],
    	['D','Descontinuado'],
    	['O','Obsoleto'],
    ]
});