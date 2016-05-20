var ClasificadoVista = function(){};

ClasificadoVista.thumb  = function(clasificado){
    var thumb = Vista.get("vista-clasificado-thumb").clone();
    thumb.find(".categoria").text(clasificado.categoria);
    thumb.find(".titulo").text(clasificado.titulo);
    thumb.find(".usuario .nombre").text(clasificado.usuario);
    thumb.find(".descripcion").html(clasificado.descripcion);
    thumb.find(".fecha").text(clasificado.genero_musical.join(" | "));
    
    if(clasificado.instrumento){
        thumb.find(".instrumento .nombre").html("<strong>Instrumento </strong><br>" + clasificado.instrumento);
        thumb.find(".instrumento .nivel").text(" ("+clasificado.instrumento_nivel+") ");
    }

    thumb.find('a[data-recipiente-id]').attr("data-recipiente-id", clasificado.usuario_id);
    thumb.find('a[data-recipiente-nombre]').attr("data-recipiente-nombre", clasificado.usuario);
    thumb.find('a[data-entidad-id]').attr("data-entidad-id", clasificado.id);
    thumb.find('a[data-entidad-tipo]').attr("data-entidad-tipo", 'clasificado');
    thumb.find('a[data-entidad-nombre]').attr("data-entidad-nombre", clasificado.titulo);
    
    return thumb;
}
