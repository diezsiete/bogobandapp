var SalaEnsayo = function(clasificado_datos){	
	this.$miniatura = SalaEnsayo.$plantillaMiniatura.clone();
	this.$miniatura.removeClass("hidden");
	
	this.miniaturaInsertada = false;
		
	for(var i in clasificado_datos){
		this[i] = clasificado_datos[i];
	}
}

SalaEnsayo.init = function(){
	SalaEnsayo.$section = $("#ensayos");
	SalaEnsayo.$cont = $("#ensayos .row-ensayos");
	SalaEnsayo.$plantillaMiniatura = $(".ensayo-item");
}

SalaEnsayo.instancia = function(data){
	var sala_ensayos = [];
	for(var i in data){
		sala_ensayos.push(new SalaEnsayo(data[i]));
	}
	return sala_ensayos;
}

SalaEnsayo.limpiar = function(){
	SalaEnsayo.$cont.empty();
}

SalaEnsayo.mostrar = function(filtros){
	SalaEnsayo.$section.show();
}

SalaEnsayo.ocultar = function(){
	SalaEnsayo.$section.hide();
}


SalaEnsayo.prototype.pintar = function(){
	var self = this;
	this.$miniatura.find(".item-title h4").text(this.nombre);
	this.$miniatura.find("img").attr("src", this.imagen);
	this.$miniatura.find(".localidad span").text(this.localidad);
	
	if(!this.miniaturaInsertada){
		SalaEnsayo.$cont.append(this.$miniatura);
	}
}
