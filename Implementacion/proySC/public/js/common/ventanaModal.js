var ventanaModal = null;
if(!ventanaModal){
	ventanaModal = new Ext.Window({
        layout:'anchor',
        modal: true,
        autoScroll: true,
        frame: true,
        constrainHeader:true,
        border: false,
        width: 500,
        height:350,
        closeAction:'hide',
        items: [],
        listeners:{
        	'beforeadd':function(thisCont, newCmp, index){
        		thisCont.removeAll();
        	},
        	'render':function(thisCmp)
        	{
        		thisCmp.getEl().unmask();
        	},
        	'show':function(thisCmp)
        	{
        		thisCmp.getEl().unmask();
        	}
        }
    });
}