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
}

Ajax.prototype._call = function(type, controlador_metodo, datos_envio, datos_evento, fn_exito){
    var self        = this;
    var url         = self.archivo;

    var form_data   = new FormData();
    if(typeof datos_envio == 'function') {
        fn_exito    = datos_envio;
        datos_envio = undefined;
    }else if(typeof datos_evento == 'function') {
        fn_exito    = datos_evento;
    }
    form_data.append('controlador_metodo', controlador_metodo);
    if(datos_envio) {
        if(type == "post") {
            form_data.append("post", 1);
            for (var i in datos_envio)
                form_data.append(i, datos_envio[i])
        }
        else
            form_data.append('datos_envio', JSON.stringify(datos_envio));
    }

    $.ajax({
        type: 'POST',
        url : self.archivo,
        data: form_data,
        processData: false,
        contentType: false,
        dataType:	'json',
        xhrFields: {
            withCredentials: true
        },
        success: function(json) {
            if(typeof fn_exito == 'function')
                fn_exito(json, datos_evento);
        },

        error: function(e) {
            var responseText = e.responseText;
        }
    });
}

Ajax.prototype.get = function(controlador_metodo, datos_envio, datos_evento, fn_exito) {
    this._call("get", controlador_metodo, datos_envio, datos_evento, fn_exito);
}
Ajax.prototype.post = function(controlador_metodo, datos_envio, datos_evento, fn_exito) {
    this._call("post", controlador_metodo, datos_envio, datos_evento, fn_exito);
}
