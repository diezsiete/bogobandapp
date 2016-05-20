var EventoVista = function(){};


EventoVista.thumb = function(evento){
    var thumb = Vista.get("vista-evento-thumb").clone();

    thumb.find(".entidad-thumb-title-wrap h4").text(evento.nombre)
    thumb.find("img").attr("src", evento.imagen);
    thumb.find('.usuario span').text(evento.usuario);
    thumb.find('.localidad span').text(evento.localidad);
    thumb.find('.genero_musical span').text(evento.genero_musical.join(" | "));
    thumb.find('.evento_tipo span').text(evento.evento_tipo);

    thumb.find('a[data-recipiente-id]').attr("data-recipiente-id", evento.usuario_id);
    thumb.find('a[data-recipiente-nombre]').attr("data-recipiente-nombre", evento.usuario);
    thumb.find('a[data-entidad-id]').attr("data-entidad-id", evento.id);
    thumb.find('a[data-entidad-tipo]').attr("data-entidad-tipo", 'evento');
    thumb.find('a[data-entidad-nombre]').attr("data-entidad-nombre", evento.nombre);
    return thumb;
};
