var MensajeVista = function(){}

MensajeVista.modal = function(recipiente_titulo) {
    if(!this.m){
        this.m = Vista.modal("modal-enviar-mensaje");
        this.mTit = this.m.find(".modal-title span");
        this.mTextArea = this.m.find("textarea");
    }
    this.mTit.text(recipiente_titulo);
    this.mTextArea.val("");
    return this.m;
}

MensajeVista.verMensajes = function(mensajes){
    if(!this.$verMensajes){
        this.$verMensajes = Vista.get('vista-ver-mensajes');
        this.$verMensajesContMensajes = this.$verMensajes.find('.mensajes-contenedor .container');
        this.$verMensajesConversaciones = this.$verMensajes.find('.mensajes-conversaciones .container');
    }
    if(!mensajes.length){
        this.$verMensajesContMensajes.addClass("no-mensajes");
        this.$verMensajesConversaciones.parent().addClass("hidden");
        this.$verMensajesContMensajes.parent().removeClass("col-md-8 col-md-12").addClass("col-md-12");
    }else{
        this.$verMensajesContMensajes.removeClass("no-mensajes");
        this.$verMensajesConversaciones.parent().removeClass("hidden");
        this.$verMensajesContMensajes.parent().removeClass("col-md-8 col-md-12").addClass("col-md-8");
    }

    Vista.$paginaContenedor.append(this.$verMensajes);
}