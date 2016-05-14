/**
 * Clase para realizar llamadas desde la aplicacion al servidor
 * BogoBandApp 2016
 */


/**
 * Constructor del objeto
 * @param ajax_archivo string el archivo al que se hacen las solicitudes ajax
 * @returns
 */
Ajax = function(ajax_archivo){
	this.archivo = ajax_archivo;
	//this.archivo += "?callback=?";
	this.solicitudCuenta = 0;
}

/**
 * Realizar solicitud ajax al servidor
 * @param funcion_servidor string nombre de la funcion que se desea llamar en servidor
 * @param datos object objeto json con los objetos a pasar a la funcion
 * @param fn_exito function funcion que se llama cuando se recibe respuesta del servidor
 * @param datos_evento object  objeto que podemos pasar variables que podremos acceder  en fn_exito
 */
Ajax.prototype.solicitud = function(funcion_servidor, datos, fn_exito, datos_evento){
	var self = this;
	
	datos['solicitud'] = funcion_servidor;
	datos['solicitud_cuenta']    = this.solicitudCuenta;
	this.solicitudCuenta++;
	
	datos_serial = jQuery.param(datos);
	
	$.ajax({
	   type: 'GET',
	    url: self.archivo,
	    data : datos_serial,
	    jsonpCallback: 'respuesta' + datos['solicitud_cuenta'] ,
	    contentType: "application/json",
	    dataType: 'jsonp',
	    success: function(json) {
	    	fn_exito(json, datos_evento);
	    },
	    error: function(e) {
	    	console.log(e.message);
	    }
	});
	
	
}
