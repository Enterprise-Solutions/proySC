
function formatearFecha(date, formato)
{
	if(!date)
		return null;
	
	var fecha;
	
	switch(formato)
	{
		//dd-mm-yyyy
		case 1:
			fecha = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
			break;
	}
	
	return fecha;
}