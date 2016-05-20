var UsuarioControlador = function(){}

UsuarioControlador.init = function(){
    var self = this;
    /**
     * Id de usuario con sesión abierta si no tiene será 0
     * @type {integer}
     */
    self.id = 0;
    self.formaIniciarSesion = Forma.get("iniciar-sesion");
    self.formaRegistro      = Forma.get("registro");
    self.$modalRegistro = Vista.modal('modal-registro');

    //Acciones
    //iniciar sesion
    self.formaIniciarSesion.$.submit(function(e){
        e.preventDefault();
        self.iniciarSesionAccion();
    });
    //cerrar sesión
    $("#cerrar-sesion a").click(function(e){
        e.preventDefault();
        self.cerrarSesionAccion();
    });
    //iniciar registro
    self.$modalRegistro.on("shown.bs.modal", function(){
        self.registroIniciarAccion();
    });
    //registrarse
    self.formaRegistro.$.submit(function(e){
        e.preventDefault();
        self.registroAccion();
    });
    
    //eventos
    this._crearEvento('sesionAbierta');

}

UsuarioControlador.sesionAccion = function(call){
    var self = this;
    
    ajx.get('UsuarioControlador::sesionAccion', function(data){
        self.id = data.id;
        call(self.id);
    })
}

UsuarioControlador.iniciarSesionAccion = function(){
    var self = this;
    var usuario = this.$formaIniciarSesion.val('usuario');
    var clave   = this.$formaIniciarSesion.val('clave');
    ajx.get('UsuarioControlador::iniciarSesionAccion', {usuario : usuario, clave : clave}, function(data){
        if(data.id) {
            Vista.modal('modal-iniciar-sesion').modal('hide');
            self._llamarEvento('sesionAbierta', data);
        }else{
            
        }
    })
};

UsuarioControlador.cerrarSesionAccion = function(){
    ajx.get("UsuarioControlador::cerrarSesionAccion", function(){
        App.sesionCerradaAccion();
    })
};

UsuarioControlador.registroIniciarAccion = function() {
    var self = this;
    if(!this.primerRegistro){
        this.primerRegistro = true;
        ajx.get("UsuarioControlador::getLocalidadAccion", function(localidades) {
            UsuarioVista.registro(localidades);
        });
    }else{
        UsuarioVista.registro();
    }
}
UsuarioControlador.registroAccion = function(){
    var campos = this.formaRegistro.$.serialize();
    ajx.post('UsuarioControlador::registroAccion', {campos : campos}, function(response){
    
    });
}


