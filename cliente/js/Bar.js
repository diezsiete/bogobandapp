/**
 * Clase para representar bar en la interfaz
 */

/**
 * constructor de un bar, al cual se pasan sus datos basicos segun recibidos por servidor
 */
var Bar = function(bar_datos){	
	this.$miniatura = Bar.$plantillaMiniatura.clone();
	this.$miniatura.removeClass("hidden");
	
	this.miniaturaInsertada = false;
		
	for(var i in bar_datos){
		this[i] = bar_datos[i];
	}
}

/**
 * Metodo estatico Inicializar la sección de bares, para pintar los bares a mostrar
 */
Bar.init = function(){
	Bar.$section = $("#bares");
	Bar.$cont = $("#bares .row-bares");
	Bar.$plantillaMiniatura = $(".bar-item");
}

/**
 * Metodo estatico Utilizada para crear multiples instancias de bar segun información recibida por servidor
 * @param data objeto con un o multiples datos de bar
 * @returns {Array} de las instancias bar creadas
 */
Bar.instancia = function(data){
	var bares = [];
	for(var i in data){
		bares.push(new Bar(data[i]));
	}
	return bares;
}

/**
 * Metodo estatico para limpiar la sección donde se muestran los bares
 * util cuando se desean mostrar otros segun cambio de filtros 
 */
Bar.limpiar = function(){
	Bar.$cont.empty();
}
/**
 * La seccion de bares puede estar oculta si se esta en otra seccion,
 * mostrar esta seccion
 */
Bar.mostrar = function(){
	Bar.$section.show();
}
/**
 * Ocultar la seccion de bares
 */
Bar.ocultar = function(){
	Bar.$section.hide();
}

/**
 * Metodo instancia que pinta el objeto en la interfaz
 */
Bar.prototype.pintar = function(){
	var self = this;
	this.$miniatura.find(".item-title h4").text(this.nombre);
	this.$miniatura.find("img").attr("src", this.imagen);
	this.$miniatura.find(".localidad span").text(this.localidad);
	this.$miniatura.find(".genero_musical span").text(this.genero_musical.join(" | "));
	
	if(!this.miniaturaInsertada){
		Bar.$cont.append(this.$miniatura);
	}
}
