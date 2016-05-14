/**
 * Clase que representa la entidad clasificado
 */

/** 
 * Constuctor de un clasificado
 * @param clasificado_datos object los datos del clasificado segun envia servidor
 */
var Clasificado = function(clasificado_datos){	
	this.$miniatura = Clasificado.$plantillaMiniatura.clone();
	this.$miniatura.removeClass("hidden");
	
	this.miniaturaInsertada = false;
		
	for(var i in clasificado_datos){
		this[i] = clasificado_datos[i];
	}
}

/**
 * Metodo estatico para inicializar elementos DOM necesarios
 */
Clasificado.init = function(){
	Clasificado.$section = $("#clasificados");
	Clasificado.$cont = $("#clasificados .row-clasificados");
	Clasificado.$plantillaMiniatura = $(".clasificado-item");
}

/**
 * Metodo estatico para crear instancias de clasificado segun datos enviados por servidor
 * @param data objeto con los datos de uno o multiples clasificados
 * @returns {Array} de instancias Clasificado creadas
 */
Clasificado.instancia = function(data){
	var clasificados = [];
	for(var i in data){
		clasificados.push(new Clasificado(data[i]));
	}
	return clasificados;
}

/**
 * Limpiar el contenedor de instancias pintadas en la interfaz de usuario
 */
Clasificado.limpiar = function(){
	Clasificado.$cont.empty();
}
/**
 * Mostrar el contenedor de instancias pintadas, que puede estar oculto
 */
Clasificado.mostrar = function(){
	Clasificado.$section.show();
}
/**
 * Ocultar el contenedor de instancias pintadas, para dar paso a mostrar otra pagina
 */
Clasificado.ocultar = function(){
	Clasificado.$section.hide();
}

/**
 * Metodo de instancia que permite pintar el clasificado en la interfaz de usuario
 */
Clasificado.prototype.pintar = function(){
	var self = this;
	this.$miniatura.find(".categoria").text(this.categoria);
	this.$miniatura.find(".titulo").text(this.titulo);
	this.$miniatura.find(".usuario .nombre").text(this.usuario);
	this.$miniatura.find(".descripcion").html(this.descripcion);
	if(this.instrumento){
		this.$miniatura.find(".instrumento .nombre").html("<strong>Instrumento </strong><br>" + this.instrumento);
		this.$miniatura.find(".instrumento .nivel").text(" ("+this.instrumento_nivel+") ");
	}
	this.$miniatura.find(".fecha").text(this.genero_musical.join(" | "));

	if(!this.miniaturaInsertada){
		Clasificado.$cont.append(this.$miniatura);
		this.$miniatura.click(function(e){
			e.preventDefault();
		});
		this.$miniatura.hover(function(){
			self.$miniatura.find(".hover-info").show();
		}, function(){
			self.$miniatura.find(".hover-info").hide();
		})
	}
}
