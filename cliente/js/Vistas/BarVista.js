var BarVista = function(){}

BarVista.thumb = function(bar){
    var thumb = Vista.get("vista-bar-thumb").clone();
    thumb.find(".entidad-thumb-title-wrap h4").text(bar.nombre);
    thumb.find("img").attr("src", bar.imagen);
    thumb.find(".localidad span").text(bar.localidad);
    thumb.find(".genero_musical span").text(bar.genero_musical.join(" | "));

    thumb.find('a[data-recipiente-id]').attr("data-recipiente-id", bar.id);
    thumb.find('a[data-recipiente-nombre]').attr("data-recipiente-nombre", bar.nombre);
    
    return thumb;
}
