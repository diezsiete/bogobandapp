var FiltroAcordeon = function(titulo){
	var self = this;
	
	this.$contenedor   = $('<fieldset id="filtro-localidad" class="acordeon">' +
						 '	<header>'+titulo+'</header> ' +
						 '  <div class="option-wrap hidden"></div> ' +
						 '</fieldset>');
	this.$header     = this.$contenedor.find("header");
	this.$optionWrap = this.$contenedor.find(".option-wrap");
	this.options  = [];
	
	this.$header.click(function(){
		self.$optionWrap.toggleClass("hidden");
	});
	
	this.onChangeFunciones = [];
}

FiltroAcordeon.prototype.limpiar = function(){
	for(var i = 0; i < this.options.length; i++)
		this.options[i].removeClass("selected");
}
FiltroAcordeon.prototype.ocultar = function(){
	this.$contenedor.addClass("hidden");
}
FiltroAcordeon.prototype.esOculto = function(){
	return this.$contenedor.hasClass("hidden");
}
FiltroAcordeon.prototype.mostrar = function (){
	this.$contenedor.removeClass("hidden");
}
FiltroAcordeon.prototype.llenar = function(datos){
	var self = this;
	for(var id in datos){
		var option = $('<div class="option" data-valor="'+id+'">'+datos[id]+'</div>');
		option.click(function(e){
			self.opcionClic($(this));
		});
		this.options.push(option);
		this.$optionWrap.append(option);
	}
}
FiltroAcordeon.prototype.onChange = function(funcion){
	this.onChangeFunciones.push(funcion);
}

FiltroAcordeon.prototype.opcionClic = function($option){
	$option.toggleClass('selected');
	for(var j in this.onChangeFunciones)
		this.onChangeFunciones[j]($option.data("valor"));
		
}

FiltroAcordeon.prototype.getOpcionesSel = function(){
	var opciones_sel = [];
	for(var i = 0; i < this.options.length; i++){
		if(this.options[i].hasClass('selected'))
			opciones_sel.push(this.options[i].data("valor"));
	}
	return opciones_sel;
}

FiltroAcordeon.prototype.vista = function(){
    return this.$contenedor;
}

