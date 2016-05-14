/**
 * Clase que reperesenta la entidad evento y presta servicios adicionales para pintar
 * correctamente la información en la interface de usuario
 */
var Evento = function(evento_datos){	
	this.$miniatura = Evento.$plantillaMiniatura.clone();
	this.$miniatura.removeClass("hidden");
	
	this.miniaturaInsertada = false;
		
	for(var i in evento_datos){
		this[i] = evento_datos[i];
	}
}

/**
 * Metodo estatico para obtener objetos DOM necesarios para la clase
 */
Evento.init = function(){
	Evento.$section = $("#eventos");
	Evento.$cont = $("#eventos .row-eventos");
	Evento.$plantillaMiniatura = $(".evento");
}

/**
 * Metodo estatico para crear instancias de Evento segun datos enviados por servidor
 * @param data objeto con los datos de uno o multiples eventos
 * @returns {Array} de instancias Evento creadas
 */
Evento.instancia = function(data){
	var eventos = [];
	for(var i in data){
		eventos.push(new Evento(data[i]));
	}
	return eventos;
}

/**
 * Limpiar el contenedor de instancias pintadas en la interfaz de usuario
 */
Evento.limpiar = function(){
	Evento.$cont.empty();
}

/**
 * Mostrar el contenedor de instancias pintadas, que puede estar oculto
 */
Evento.mostrar = function(filtros){
	Evento.$section.show();
}

/**
 * Ocultar el contenedor de instancias pintadas, para dar paso a mostrar otra pagina
 */
Evento.ocultar = function(){
	Evento.$section.hide();
}

Evento.prototype.pintar = function(){
	this.$miniatura.find(".evento-thumb-title-wrap h4").text(this.nombre)
	this.$miniatura.find("img").attr("src", this.imagen);
	this.$miniatura.find('.usuario span').text(this.usuario);
	this.$miniatura.find('.localidad span').text(this.localidad);
	this.$miniatura.find('.genero_musical span').text(this.genero_musical.join(" | "));
	this.$miniatura.find('.evento_tipo span').text(this.evento_tipo);
	if(!this.miniaturaInsertada){
		Evento.$cont.append(this.$miniatura)
	}
}