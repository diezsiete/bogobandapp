var EntidadControlador = function(){
}

EntidadControlador.init = function(entidad) {
    var hijo_controlador = window[Utils.ucfirst(entidad) + 'Controlador'];

    Utils.hereda(hijo_controlador, EntidadControlador);
    hijo_controlador.entidad = entidad;

    /**
     * 
     * @type {{}}
     * @private
     */
    hijo_controlador._eventos = {};
    
    hijo_controlador.init();
}

EntidadControlador._crearEvento = function(evento_nombre){
    this._eventos[evento_nombre] = [];
}

/**
 * Procedimiento interno para llamar eventos suscritos al objeto
 */
EntidadControlador._llamarEvento = function(){
    var evento = arguments[0];
    var args = [];
    Array.prototype.push.apply( args, arguments );
    args.shift();
    for(var i = 0; i < this._eventos[evento].length; i++){
        this._eventos[evento][i].apply(this, args);
    }
}

/**
 * subscribir funciones a llamar en eventos del objetos, para ver eventos mirar this._events
 */
EntidadControlador.on = function(evento_nombre, call_func){
    this._eventos[evento_nombre].push(call_func);
}