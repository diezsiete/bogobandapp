var AplicarVista = function(){}

AplicarVista.modal = function(entidad_tipo, entidad_nombre) {
    if(!this.m){
        this.m = Vista.modal("modal-aplicar-confirmar");
        this.mTit = this.m.find(".modal-title span");
        this.mBodyE = this.m.find(".modal-body span.entidad");
        this.mBodyN = this.m.find(".modal-body span.nombre");
    }

    this.mTit.text(entidad_tipo);
    this.mBodyE.text(entidad_tipo);
    this.mBodyN.text(entidad_nombre);
    return this.m;
}