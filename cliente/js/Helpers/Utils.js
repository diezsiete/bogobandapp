var Utils = function(){}

Utils.ucfirst = function (str) {
    return typeof str !="undefined"  ? (str += '', str[0].toUpperCase() + str.substr(1)) : '' ;
}

Utils.hereda  = function (hijo, padre){
    hijo.prototype = Object.create( padre.prototype );

    Object.keys( padre ).forEach( function( key ) {
        if(!hijo[key])
            hijo[ key ] = padre[ key ];
    } );

    hijo.padre = padre;
}