var myLatLng = new google.maps.LatLng(-31.416667, -64.183333);
var mapOptions = {
	zoom: 3,
	center: myLatLng,
	mapTypeId: google.maps.MapTypeId.RoadMap
};

var map;
var regionPol;
var zonasPol;

var xPiedra;



$(document).ready(function(){

	map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
	
	setTypeahead('#searchRegion', 'getRegiones', 'id', 'region','hiddenRegionID');
	
	$('#newP_form').validate({
		ignore: [],
		lang: 'es',
        rules: {
            zona: {
				required: true,
                minlength: 3,
                maxlength: 20
            },
			hiddenRegionID: {
				required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
		 submitHandler: function(form) {
			var suspend = false;
			getPolygonCoords();
			alert(google.maps.geometry.spherical.computeArea(xPiedra.getPath()));
			if (!suspend) {				
				dataString = $("#newP_form").serialize();			 
				$.ajax({
					type: "POST",
					url: "/geologic/piedraspreciosas/save",
					data: dataString,			 
					success: function(data){
						data ? (window.location.href = "/geologic/piedraspreciosas/") : "";
					}		 
				});			 
			}			
		}
    });
	
	
	//
	

	
	$('#polygon_main_add').on('click', function(){
		
		if(typeof(xPiedra) != 'undefined') {
			xPiedra.setMap(null);
		}		
	
		function get_random_value(val_max) {
            val_max = val_max || 100;
            return Math.floor((Math.random()*val_max));
        }
		
		
		var px_center = map.getCenter();
		
		xPiedra = new google.maps.Marker({
			position: myLatLng,
			map: map,
			draggable: true,
			editable: true,			
			title: "Piedra Preciosa"
		});
				
		xPiedra.setMap(map);
		
    });
	
	
	
	//
	
});


function setTypeahead(objdom, xrhfrunc, dataId, dataProperty, hiddencell) {

	$(objdom).typeahead({ 
		source: function(query, process) {
			var $url = '/geologic/piedraspreciosas/' + xrhfrunc;
			var $items = new Array;
			$items = [""];
			$.ajax({
				url: $url,
				data: { stringQuery: query },
				dataType: "json",
				type: "POST",
				success: function(data) {
					//console.log(data);
					//empty array
					//elmnts.length = 0;					
					$.map(data, function(data){
						//elmnts.push(data[dataProperty]);						
						var group;
						group = {
							id: data[dataId],
							descriptionField: data[dataProperty],                          
							toString: function () {
								return JSON.stringify(this);
								//return this.app;
							},
							toLowerCase: function () {
								return this.descriptionField.toLowerCase();
							},
							indexOf: function (string) {
								return String.prototype.indexOf.apply(this.descriptionField, arguments);
							},
							replace: function (string) {
								var value = '';
								value +=  this.descriptionField;
								if(typeof(this.level) != 'undefined') {
									value += ' <span class="pull-right muted">';
									value += this.level;
									value += '</span>';
								}
								return String.prototype.replace.apply('<div style="width:' + $('#search').width() + 'px;">' + value + '</div>', arguments);
							}
						};
						$items.push(group);
					});

					process($items);
				}
			});
		},
		property: dataProperty,
		items: 20,
		minLength: 2,
		updater: function (item) {
			var item = JSON.parse(item);

			$('#' + hiddencell).val(item.id); 
			gotoRegion(item.id);
			return item.descriptionField;
		}
	});

}

function gotoRegion(regId) {	
	
	if(typeof(xPiedra) != 'undefined') {
			xPiedra.setMap(null);
	}
		
	$.each(ZS.regiones, function(index, value) {		
		if (value.id == regId) {
			zonasPol = null;
			if(typeof(regionPol) != 'undefined') {
				regionPol.setMap(null);
			}		
			var regionCoords = [];
			$.each(value.coords , function(indexx, valuex) {
				regionCoords.push(new google.maps.LatLng(valuex['lat'], valuex['lng']));				
			});			
			regionPol = new google.maps.Polygon({
				paths: regionCoords,
				draggable: false,
				editable: false,
				strokeColor: '#' + value.color,
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: '#' + value.color ,
				fillOpacity: 0.3,
				zIndex: 0
			});			
			regionPol.setMap(map);				
			var latLng = new google.maps.LatLng(value.c_lat, value.c_lng); //Makes a latlng
			map.setZoom(value.c_zoom);
			map.panTo(latLng);

			zonasPol = new Array();
			$.each(ZS.zonas , function(indexx, valuex) {
				if ((valuex.region_id == value.id) && (valuex.coords.length > 0)) {
					zonasPol[indexx] = new Array();
					zonasPol[indexx]['coords'] = new Array();
					$.each(valuex.coords , function(indexxx, valuexx) {
						zonasPol[indexx]['coords'].push( new google.maps.LatLng(valuexx['lat'], valuexx['lng']) );						
					});
					zonasPol[indexx]['zmap'] = new google.maps.Polygon({
												paths: zonasPol[indexx]['coords'],
												draggable: false,
												editable: false,
												strokeColor: '#ff2012',
												strokeOpacity: 0.8,
												strokeWeight: 2,
												fillColor: '#ff2012',
												fillOpacity: 0.5,
												zIndex: 1
											});	
					zonasPol[indexx]['zmap'].setMap(map);
					
					google.maps.event.addListener(zonasPol[indexx]['zmap'], 'click', function(event) {
						
						var infowindow = new google.maps.InfoWindow();
						var contentString = '<div id="content" style="width:250px; height: 100px;">'+
							'Zona ' + valuex.name + '<br>' + 
							'Area: ' + google.maps.geometry.spherical.computeArea(zonasPol[indexx]['zmap'].getPath()) + ' mts2' + 							
						  '</div>';

						infowindow.setContent(contentString);
						infowindow.setPosition(event.latLng);
						infowindow.open(map);
					});
					
				}
			});
			
			
			
		}
	}); 
}

function getPolygonCoords() {	
	var polygonBounds = xPiedra.getPath();
	var coordinates = [];
	for(var i = 0 ; i < polygonBounds.length ; i++) coordinates.push(polygonBounds.getAt(i).lat(), polygonBounds.getAt(i).lng());	
	$("#coord").val(coordinates);
}

