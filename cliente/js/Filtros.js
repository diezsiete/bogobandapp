var Filtros = function(){}

Filtros.init = function(funcion_respuesta_filtros){
	Filtros.funcionRespuestaFiltros = funcion_respuesta_filtros;
	
	Filtros.$paginaContenedor = $("#pagina-contenedor"); 
	Filtros.$textoContenedor  = $(".search-phrase-container");
	Filtros.$mostrarPanel = $(".mostrar-filtros-panel");
	Filtros.$panel = $("#filtros-contenedor");
	Filtros.$btnBuscar = $("#search-form-button");
	Filtros.$ftexto = $("#ftexto");
	Filtros.$form = $("#filtro");
	
	Filtros.widgets = {};
	
	Filtros.widgets.localidad     = new FiltroAcordeon("#filtro-localidad");
	Filtros.widgets.generoMusical = new FiltroAcordeon("#filtro-genero-musical");
	Filtros.widgets.eventoTipo    = new FiltroAcordeon("#filtro-evento-tipo");
	Filtros.widgets.categoriaClasificado = new FiltroAcordeon("#filtro-categoria-clasificado"); 
	Filtros.widgets.instrumento   = new FiltroAcordeon("#filtro-instrumento");
	
	Filtros.filtros = {};
	
	
	Filtros.widgets.localidad.onChange(function(){ Filtros.onSelect() });
	Filtros.widgets.generoMusical.onChange(function(){ Filtros.onSelect() });
	Filtros.widgets.eventoTipo.onChange(function(){ Filtros.onSelect() });
	Filtros.widgets.categoriaClasificado.onChange(function(){ Filtros.onSelect() }); 
	Filtros.widgets.instrumento.onChange(function(){ Filtros.onSelect() });
	
	//llenar acordeones
	Filtros._llenarWidgets();
	
	//en mostrar saber que filtros haver visibles para cada quien
	Filtros.config = {
		evento : ["localidad", "generoMusical", "eventoTipo"],
		clasificado : ["categoriaClasificado", "generoMusical", "instrumento"],
		bar : ["localidad", "generoMusical"],
		salaEnsayo : ["localidad"],
	};
	
	Filtros.$mostrarPanel.find("a").click(function(){
		if(!$("#filtros-contenedor").toggleClass("hidden").hasClass("hidden"))
			Filtros.$paginaContenedor.addClass("con-filtros");
		else
			Filtros.$paginaContenedor.removeClass("con-filtros");
	});
	
	Filtros.$form.submit(function(e){
		e.preventDefault();
		Filtros.filtrar();
	});
}
Filtros._mostrar = function(cual){
	Filtros.filtros = {};
	for(var i in Filtros.widgets){
		Filtros.widgets[i].limpiar();
		Filtros.widgets[i].ocultar();
	}
	for(var i = 0; i < Filtros.config[cual].length; i++){
		var x = Filtros.config[cual][i];
		Filtros.widgets[Filtros.config[cual][i]].mostrar();
	}
	Filtros.$mostrarPanel.removeClass("hidden");
	Filtros.$textoContenedor.addClass("con-filtros");
}
Filtros._llenarWidgets = function(){
	for(var i in Filtros.widgets){
		var ajax_solicitud = 'get' + i.substr(0, 1).toUpperCase() + i.substr(1);
		ajax.solicitud(ajax_solicitud, {}, function(datos, datos_evento){
			Filtros.widgets[datos_evento.widget].llenar(datos);
		},{widget : i});
	}
}

Filtros.filtrar = function(){
	var texto_val = Filtros.$ftexto.val();
	
	Filtros.filtros["texto"] = texto_val;
	
	var ent = {'Evento' : {}, 'Clasificado' : {}, 'Bar' : {}, 'SalaEnsayo' : {}};
	switch(App.vista){
		case 'evento' :      ent = {'Evento' : {}}; break;
		case 'clasificado' : ent = {'Clasificado' : {}}; break;
		case 'bar' :        ent = {'Bar' : {}}; break;
		case 'salaEnsayo' :      ent = {'SalaEnsayo' : {}}; break;
	}
	for(var i in ent)
		ent[i] = Filtros.filtros;
	
	ajax.solicitud('filtrar', {'filtros' : ent}, function(data){
		Filtros.funcionRespuestaFiltros(data);
	});
		
}

Filtros.mostrarEvento = function(){
	Filtros._mostrar('evento');
}
Filtros.mostrarClasificado = function(){
	Filtros._mostrar('clasificado');
}
Filtros.mostrarBar = function(){
	Filtros._mostrar('bar');
}
Filtros.mostrarSalaEnsayo = function(){
	Filtros._mostrar('salaEnsayo');
}
Filtros.ocultar = function(){
	Filtros.$paginaContenedor.removeClass("con-filtros");
	Filtros.$textoContenedor.removeClass("con-filtros");
	Filtros.$mostrarPanel.addClass("hidden"); 
	Filtros.$panel.addClass("hidden");
}

Filtros.onSelect = function(){
	for(var i in Filtros.widgets){
		if(!Filtros.widgets[i].esOculto()){
			Filtros.filtros[i] = Filtros.widgets[i].getOpcionesSel();
		}
	}
	Filtros.filtrar();
}