var BuscarVista = function(){}

BuscarVista.buscador = function(filtros){
    typeof filtros == "undefined" ? filtros = [] : null;


    if(!this.$buscadorCont){
        this.$buscadorCont = Vista.get("vista-buscador");
        this.$buscadorMostrarFiltrosBtn = this.$buscadorCont.find(".mostrar-filtros-panel");
        this.$buscadorFiltrosCont = this.$buscadorCont.find("#filtros-form");
        this.$buscadorMostrarFiltrosBtn.find("a").click(function(){
            if(!$("#filtros-contenedor").toggleClass("hidden").hasClass("hidden"))
                Vista.$paginaContenedor.addClass("con-filtros");
            else
                Vista.$paginaContenedor.removeClass("con-filtros");
        });
    }
    
    Vista.$wrapper.prepend(this.$buscadorCont);

    this.$buscadorFiltrosCont.children().detach();

    if(filtros.length > 0){
        this.$buscadorMostrarFiltrosBtn.removeClass("hidden");
        for(var i = 0; i < filtros.length; i++)
            this.$buscadorFiltrosCont.append(filtros[i]);
    }else{
        this.$buscadorMostrarFiltrosBtn.addClass("hidden");
        $("#filtros-contenedor").hasClass("hidden") ? null : $("#filtros-contenedor").toggleClass("hidden");
        Vista.$paginaContenedor.removeClass("con-filtros");
    }
}

BuscarVista.buscarEntidad = function(titulo, thumbs){
    var cont = Vista.clonar("vista-buscar-entidad");
    var cont_thumbs = cont.find(".row.row-thumbs");
    
    cont.find("h2.section-heading").text(titulo);


    if(typeof thumbs == 'function'){
        thumbs(function(thumbs){
            cont_thumbs.append(thumbs);
        })
    }else
        for(var i = 0; i < thumbs.length; i++)
            cont_thumbs.append(thumbs[i]);
    
    Vista.$paginaContenedor.append(cont);
}
