var UsuarioPruebas = function(){};

UsuarioPruebas._registro = function(){
}

UsuarioPruebas.registroMusico = function(){
    var valores = {
        'correo'   : 'jose.guerrero@javeriana.edu.co',
        'telefono' : '2590015',
        'celular'  : '3202123926',
        'username' : 'jguerrero',
        'password' : 'jguerrero',
    };
    
    var $modalRegistro = Vista.modal('modal-registro');
    var form = Forma.get('registro');

    
    ajx.get("UsuarioControlador::getLocalidadAccion", function(localidades) {
        UsuarioVista.registro(localidades);

        $modalRegistro.modal("show");

        for(var i in valores)
            form.val(i, valores[i]);

        var x = $modalRegistro.find('button[data-perfil="m"]');
        debugger

    });


};