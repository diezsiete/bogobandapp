/**
 * Clase principal que maneja la aplicacion
 */
var App = function(){};

/** 
 * metodo para inicializar valores como objetos del DOM para utilizar posteriormente
 */
App.init = function(){
	var $menuLinkSelected = false;
	
	App.$paginaContenedor = $("#pagina-contenedor"); 
	
	App.vista = 'main';
	
	App.entidades = ['Evento', 'Clasificado', 'Bar', 'SalaEnsayo'];
	
	App.$menu = {
		main : $(".navbar-header"),
		evento : $("#navbar-evento"),
		clasificado : $("#navbar-clasificado"),
		bar : $("#navbar-bar"),
		salaEnsayo : $("#navbar-salaEnsayo"),
	};
	
	for(var i in App.$menu){
		App.$menu[i].find('a').click({"j" : i}, function(e){
			e.preventDefault();
			
			if($menuLinkSelected)
				$menuLinkSelected.removeClass("selected");
			$menuLinkSelected = $(this).parent();
			$menuLinkSelected.addClass("selected");
			
			
			e.data.j == 'main' ? App.mostrarMain() : App.mostrarEntidad(e.data.j);
		})
	}
	for(var i = 0; i < App.entidades.length; i++)
		window[App.entidades[i]].init();
	
	Filtros.init(function(data){
		App.pintarRespFiltros(data);
	});
	
	App.mostrarMain();
}

/**
 * Dada una solicitud de filtros a servidor, los datos recibidos se pintan en la aplicacion
 * @param data object de la forma {evento : {..}, clasificado : {...}, .. }
 */
App.pintarRespFiltros = function(data){
	for(var i in data){
		window[i].limpiar();
		var objs = window[i].instancia(data[i]);
		for(var j = 0; j < objs.length; j++)
			objs[j].pintar();
		window[i].mostrar();
	}
}

/**
 * LLamada en usuario selecciona ver pagina principal
 */
App.mostrarMain = function(){
	App.vista = 'main';
	Filtros.ocultar();
	Filtros.filtrar();
	App.$paginaContenedor.removeClass("con-filtros-mobile");
}
/**
 * Llamada en usuario selecciona ver pagina especializada, oculta lo demas y muestra  la deseada
 * @param entidad la entidad a mostrar sea evento, clasificado, bar, salaEnsayo
 */
App.mostrarEntidad = function(entidad){
	App.$paginaContenedor.addClass("con-filtros-mobile");
	
	var filtro_fn = "mostrar" +  entidad.substr(0, 1).toUpperCase() + entidad.substr(1);
	
	Filtros[filtro_fn]();
	
	for(var i = 0; i < App.entidades.length; i++)
		if(App.entidades[i] != entidad)
			window[App.entidades[i]].ocultar();
	
	App.vista = entidad;
	Filtros.filtrar();
}
