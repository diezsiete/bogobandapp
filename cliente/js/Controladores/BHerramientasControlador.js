var BHerramientasControlador = function(){}

BHerramientasControlador.init = function(){
    var self = this;
    
    this.$liSelected = false;

    this.$navbar  = $(".navbar");
    
    $(".navbar-nav li a:first-child, .navbar .navbar-brand").click(function(e){

        if(self.$liSelected)
            self.$liSelected.removeClass("selected");

        if($(this).hasClass("#menu-logo-principal")) {
            self.$liSelected = false;
        }else{
            var $li = $(this).parent('li');
            $li.addClass("selected");
            self.$liSelected = $li;
        }
    })
}

BHerramientasControlador.mostrarAccion = function(){
    this.$navbar.removeClass("hidden");
}
BHerramientasControlador.ocultarAccion = function(){
    this.$navbar.addClass("hidden");
}