var myLatLng = new google.maps.LatLng(-31.416667, -64.183333);
var mapOptions = {
	zoom: 3,
	center: myLatLng,
	mapTypeId: google.maps.MapTypeId.RoadMap
};

var map;
var regionPol;
var zonasPol;

var xZona;

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
			alert(google.maps.geometry.spherical.computeArea(xZona.getPath()));
			if (!suspend) {				
				dataString = $("#newP_form").serialize();			 
				$.ajax({
					type: "POST",
					url: "/geologic/zonas/save",
					data: dataString,			 
					success: function(data){
						data ? (window.location.href = "/geologic/zonas/") : "";
					}		 
				});			 
			}			
		}
    });
	
	
	//
	

	
	$('#polygon_main_add').on('click', function(){
		
		if(typeof(xZona) != 'undefined') {
			xZona.setMap(null);
		}		
	
		function get_random_value(val_max) {
            val_max = val_max || 100;
            return Math.floor((Math.random()*val_max));
        }
		
		
		var px_center = map.getCenter();
		
		var polygon_width = 300;
        var polygon_height = 200;

        var px_bl_x = parseInt(px_center.k - (0)) + get_random_value(2);
        var px_bl_y = parseInt(px_center.B + (0)) + get_random_value(2);

        var px_br_x = parseInt(px_center.k + (0)) + get_random_value(2);
        var px_br_y = parseInt(px_center.B + (0)) + get_random_value(2);
        
        var px_tr_x = parseInt(px_center.k + (0)) + get_random_value(2);
        var px_tr_y = parseInt(px_center.B - (0)) + get_random_value(2);
        
        var px_tl_x = parseInt(px_center.k - (0)) + get_random_value(2);
        var px_tl_y = parseInt(px_center.B - (0)) + get_random_value(2);
        
		
		var triangleCoords = [
			new google.maps.LatLng(px_center.k, px_center.B),
			new google.maps.LatLng(px_br_x, px_br_y),
			new google.maps.LatLng(px_tr_x, px_tr_y),
			new google.maps.LatLng(px_center.k, px_center.B)
		];
		
		xZona = new google.maps.Polygon({
			paths: triangleCoords,
			draggable: true,
			editable: true,			
			strokeColor: '#000000',
			strokeOpacity: 0.5,
			strokeWeight: 2,
			fillColor: '#CACACA',
			fillOpacity: 0.7,
			zIndex: 3
		});
				
		xZona.setMap(map);
		
    });
	
	
	
	//
	
});


function setTypeahead(objdom, xrhfrunc, dataId, dataProperty, hiddencell) {

	$(objdom).typeahead({ 
		source: function(query, process) {
			var $url = '/geologic/zonas/' + xrhfrunc;
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
	
	if(typeof(xZona) != 'undefined') {
			xZona.setMap(null);
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
					
				}
			});
			
			
			
		}
	}); 
}

function getPolygonCoords() {	
	var polygonBounds = xZona.getPath();
	var coordinates = [];
	for(var i = 0 ; i < polygonBounds.length ; i++) coordinates.push(polygonBounds.getAt(i).lat(), polygonBounds.getAt(i).lng());	
	$("#coord").val(coordinates);
}

