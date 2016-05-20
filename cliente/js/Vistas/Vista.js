var Vista = function(){
    //contenedor principal despues de la barra de tareas
    Vista.$wrapper = $("#wrapper");
    //contenedor de pagina
    Vista.$paginaContenedor = $("#pagina-contenedor");
};

Vista.get = function(vista_id){
    return $("#vistas #"  + vista_id ).children(":first");
};

Vista.clonar = function(vista_id){
    return this.get(vista_id).clone();
};

Vista.limpiarPrincipal = function(){
    this.$wrapper.children(":not(#pagina-contenedor)").detach();
    this.$paginaContenedor.children().detach();
};

Vista.modal = function(modal_id){
    return $("#modales #" + modal_id);
};