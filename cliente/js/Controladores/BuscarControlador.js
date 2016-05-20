var BuscarControlador = function() {
    var self = BuscarControlador;

    //la actual acción en la que se esta para realizar la llamada de accion filtro adecuada
    self.actualEntidad = false;

    self.$ftexto = $("#ftexto");

    self.onShownBsModalCalls = [];
    
    //widgets
    self.filtros = {
        'localidad' : { titulo : 'Localidad', tipo : 'FiltroAcordeon', widget : false},
        'generoMusical' : { titulo : 'Genero Musical', tipo : 'FiltroAcordeon', widget : false},
        'eventoTipo' : {titulo : 'Tipo de evento', tipo : 'FiltroAcordeon', widget : false},
        'categoriaClasificado' : {titulo : 'Categoria Clasificado', tipo : 'FiltroAcordeon', widget : false},
        'instrumento' : { titulo : 'Instrumento', tipo : 'FiltroAcordeon', widget : false}
    };


    self.entidades = {
        'evento'      : {titulo: "Eventos", filtros : ['localidad', 'generoMusical', 'eventoTipo']},
        'clasificado' : {titulo: "Clasificados", filtros : ['categoriaClasificado', 'generoMusical', 'instrumento']},
        'bar'         : {titulo: "Bares", filtros : ['localidad', 'generoMusical']},
        'salaEnsayo'  : {titulo: "Salas de ensayo", filtros : ['localidad']}
    };


    //Acciones
    //boton principal menu acción
    $("#menu-logo-principal").click(function (e) {
        e.preventDefault();
        self.buscarEntidadAccion(false, {});
    });

    //barra princpal entidades
    for(var entidad in self.entidades){
        $("#navbar-"+entidad+" a").click({entidad : entidad}, function(e){
            e.preventDefault();
            self.buscarEntidadAccion(e.data.entidad, {});
        })
    }

    //filtro buscador texto
    $("#filtro").submit(function(e){
        e.preventDefault();
        self.filtrarAccion();
    });
}

BuscarControlador._getFiltroAcordeon = function(filtro_id) {
    var self = this;
    if(!self.filtros[filtro_id].widget){
        self.filtros[filtro_id].widget = new FiltroAcordeon(self.filtros[filtro_id].titulo);

        var controlador_call = "BuscarControlador::get"+Utils.ucfirst(filtro_id)+"Accion";
        ajx.get(controlador_call, {}, {"filtro_id" : filtro_id}, function(data_server, data){
            self.filtros[data.filtro_id].widget.llenar(data_server);
        });

        self.filtros[filtro_id].widget.onChange(function(){
            self.filtrarAccion();
        });
    }
    return self.filtros[filtro_id].widget;
}

BuscarControlador._getEntidadThumbs = function(entidad, filtros){
    var self   = this;
    var accion = 'buscar' + Utils.ucfirst(entidad) + "Accion";

    BuscarVista.buscarEntidad(self.entidades[entidad].titulo, function(call){ 
        ajx.get("BuscarControlador::" + accion, {"filtros" : filtros}, {entidad : entidad, call : call},
            function(data_server, data){
                var thumbs = [];
                var vista_call = Utils.ucfirst(data.entidad) + "Vista";
                for(var i in data_server) {
                    thumbs.push(window[vista_call].thumb(data_server[i]));
                }
                data.call(thumbs);
            }
        )
    });
}

BuscarControlador.buscador = function(entidad){
    var filtros_widgets = [];
    if(entidad){
        for(var i = 0; i < this.entidades[entidad].filtros.length; i++) {
            var filtro = this.entidades[entidad].filtros[i];
            if(this.filtros[filtro].tipo == "FiltroAcordeon")
                filtros_widgets.push(this._getFiltroAcordeon(filtro).vista())
        }
    }
    BuscarVista.buscador(filtros_widgets);
}

BuscarControlador.buscarEntidadAccion = function(entidad, filtros){
    this.actualEntidad = entidad;
    filtros["limite"]  = 10;

    Vista.limpiarPrincipal();
    BuscarControlador.buscador(entidad);

    entidad = !entidad ? Object.keys(this.entidades) : [entidad];

    for(var i = 0; i < entidad.length; i++)
        this._getEntidadThumbs(entidad[i], filtros);
}


BuscarControlador.filtrarAccion = function(){
    var filtros = {};
    filtros["texto"] = this.$ftexto.val();
    for(var i in  this.filtros){
        if(this.filtros[i].widget && !this.filtros[i].widget.esOculto()){
            filtros[i] = this.filtros[i].widget.getOpcionesSel();
        }
    }

    this.buscarEntidadAccion(this.actualEntidad, filtros);
}
