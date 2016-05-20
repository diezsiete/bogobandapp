var UsuarioVista = function(){}

UsuarioVista.registro = function(localidades){
    var self = this;
    if(!this.$modalRegistro){
        this.$modalRegistro   = Vista.modal('modal-registro');
        this.$registroBotones = this.$modalRegistro.find('fieldset.seleccionar-entidad button');
        this.formaRegistro    = Forma.get("registro");
        this.$registroFieldsetCampos = this.formaRegistro.$.find("fieldset.campos");
        this.$registroSubmitBtn = this.formaRegistro.$.find("button.registrate");
        this.$registroBotones.click(function (e) {
            
            e.preventDefault();
            var data = $(this).data();

            var campos = self.$modalRegistro.find("div.campos").find(
                'div[data-entidad="'+data.entidad+'"], div[data-perfil="'+data.perfil+'"]').clone();

            self.$registroFieldsetCampos.empty().append(campos);
            self.$registroSubmitBtn.removeClass("hidden");
        });
        var localidades_select = this.$modalRegistro.find("select[name='localidad']");
        
        if(localidades) {
            $.each(localidades, function (localidad_id, localidad_nombre) {
                localidades_select.append($('<option>', {value: localidad_id}).text(localidad_nombre));
            });
        }

    }else{
        this.$registroFieldsetCampos.empty();
        this.$registroSubmitBtn.addClass("hidden");
    }
}