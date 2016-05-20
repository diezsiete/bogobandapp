var MensajeControlador = function(){};

MensajeControlador.init = function(){
    var self = this;
    this.modal = Vista.modal("modal-enviar-mensaje");

    //Acciones
    //abrir modal
    this.modal.on('show.bs.modal', function (e) {
        self.abrirEnviarMensajeModal(e);
    });
    //enviar mensaje
    this.modal.find('button.enviar').click(function(){
        self.enviarMensajeAccion();
    });
    //ver mensajes
    $("li#ver-mensajes a").click(function(){
        self.verMensajesAccion();
    });
    
};

MensajeControlador.abrirEnviarMensajeModal = function(event){
    this.recipiente_id     = $(event.relatedTarget).data('recipiente-id');
    this.recipiente_nombre = $(event.relatedTarget).data('recipiente-nombre');
    
    MensajeVista.modal(this.recipiente_nombre);
}

MensajeControlador.enviarMensajeAccion = function(){
    this.modal.modal('hide');
}

MensajeControlador.verMensajesAccion = function(){
    Vista.limpiarPrincipal();
    ajx.get("MensajeControlador::verMensajesAccion", function(data){
        MensajeVista.verMensajes(data);
    })
}
