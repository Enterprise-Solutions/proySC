
var stockEstadoFacturaStore = new Ext.data.ArrayStore({
	idIndex: 0,  
    fields: ['id','valor'],
    data: [
    	['P','Pagado'],
    	['A','Anulado']
    ]
});