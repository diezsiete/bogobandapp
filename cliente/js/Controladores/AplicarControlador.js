var AplicarControlador = function(){};

AplicarControlador.init = function(){
    var self = this;
    this.modal = Vista.modal("modal-aplicar-confirmar");

    //Acciones
    //abrir modal
    this.modal.on('show.bs.modal', function (e) {
        self.abrirAplicarModalAccion(e);
    });
    //enviar mensaje
    this.modal.find('button.enviar').click(function(){
        self.aplicarAccion();
    });
    
};

AplicarControlador.abrirAplicarModalAccion = function(event){
    this.entidad_id    = $(event.relatedTarget).data('entidad-id');
    this.entidad_tipo  = $(event.relatedTarget).data('entidad-tipo');
    this.entidad_nombre= $(event.relatedTarget).data('entidad-nombre');
  
    
    AplicarVista.modal(this.entidad_tipo, this.entidad_nombre);
}

AplicarControlador.aplicarAccion = function(){
    this.modal.modal('hide');
}
