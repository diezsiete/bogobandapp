var Forma = function($form){
    this.$ = $form;
    this.id = this.$.attr("id");
}

Forma.get = function(forma_id){
    return $("#forma-"+forma_id).data("forma");
}

Forma.init = function(){
    var self = this;
    $("form").each(function(){
        $(this).data("forma", new self($(this)));
    })
};
Forma.prototype.input = function(input_name){
    return this.$.find("[name='"+input_name+"']");
};
Forma.prototype.val = function(input_name, val){
    return val ? this.input(input_name).val(val) : this.input(input_name).val();
};
