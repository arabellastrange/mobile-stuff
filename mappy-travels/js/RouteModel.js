function RouteModel(){
    var originLatLng, destinationLatLng;
    var name;

    this.setOriginLatLng = function(origin){
        originLatLng = origin;
    };
    this.setDestinationLatLng = function(destination){
        destinationLatLng = destination;
    };
    this.getOriginLatLng = function(){
        return originLatLng;
    };
    this.getDestinationLatLng = function(){
        return destinationLatLng;
    };
    this.setName = function(string){
        name = string;
    };
    this.getName = function(){
        return name;
    }

}