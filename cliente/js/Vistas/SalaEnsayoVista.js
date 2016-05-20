var SalaEnsayoVista = function(){}

SalaEnsayoVista.thumb = function(sala_ensayo){
    var thumb =  Vista.get("vista-sala-ensayo-thumb").clone();
    thumb.find(".entidad-thumb-title-wrap h4").text(sala_ensayo.nombre);
    thumb.find("img").attr("src", sala_ensayo.imagen);
    thumb.find(".localidad span").text(sala_ensayo.localidad);

    thumb.find('a[data-recipiente-id]').attr("data-recipiente-id", sala_ensayo.id);
    thumb.find('a[data-recipiente-nombre]').attr("data-recipiente-nombre", sala_ensayo.nombre);

    return thumb;
}
