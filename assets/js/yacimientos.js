var myLatLng = new google.maps.LatLng(-33.000000, -64.000000);
var mapOptions = {
	streetViewControl: false,
	zoom: 3,
	center: myLatLng,
	mapTypeId: google.maps.MapTypeId.HYBRID,
	disableDefaultUI: true
};

var map;
var regionPol;
var zonasPol;
var table;
var data;

var xzona;

google.maps.Polygon.prototype.my_getBounds=function(){
    var bounds = new google.maps.LatLngBounds()
    this.getPath().forEach(function(element,index){bounds.extend(element)})
    return bounds
}

Number.prototype.round = function(places) {
  return +(Math.round(this + "e+" + places)  + "e-" + places);
}

$(document).ready(function(){

	map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
	map.setZoom(3);
	map.panTo(myLatLng);
	drawX();
	
	table = $('#yacimientosGrid').DataTable( {
		
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "/geologic/yacimientos/datatable",
			"type": "POST"
		},
		"lengthChange": false,
		"order": [[ 1, "asc" ]],
		"columns": [
			{ 
				"orderable":      false,
				"searchable":     false,
				"data": "id",
				"visible" : false
			},
			{ "data": "yacimiento" },
			{ "data": "fecha_descubrimiento" },
			{ "data": "zona" },
			{ "data": null,
			  "orderable":      false,
			  "searchable":     false,
			  "render": function ( data, type, row ) {
                    return '<a class="btn btn-danger btn-xs" href="/geologic/yacimientos/delete/' + data.id + '">Eliminar</a>';
				},
			},
		],
		"language": {
			"lengthMenu": "Mostrando _MENU_ zonas por pagina",
			"zeroRecords": "No se han encontrado resultados",
			"info": "_PAGE_ / _PAGES_",
			"search": "Buscar: ",
			"paginate": {
				"first":      "Primera",
				"last":       "Ultima",
				"next":       "Sig.",
				"previous":   "Ant."
			},
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(Filtrado de _MAX_ registros)"
		}
	} );
	
	$('#yacimientosGrid tbody').on( 'click', 'tr', function () {

		data = table.row( this ).data();
		getInfo();
		
	} );
		
	// Search Button
			
	$('#searchButton').click(function() {
		if ($('#searchInput').val().trim().length < 4) {
			$('#searchInput').val("");
		}
		$('#yacimientosGrid').DataTable().search($('#searchInput').val().trim()).draw();
	});
		
	$('#myModal').on('shown.bs.modal', function (e) {
	
		$('#zona').val('');
		$('#searchRegion').val('');
		$('#hiddenRegionID').val('');
		
		$('#rootwizard').bootstrapWizard({
			'tabClass': 'bwizard-steps',
			onNext: function(tab, navigation, index) {
				//alert(index + "on next");
				if(index==1) {					
					alert("check inputzzs");
				}				
			},
			onTabShow: function(tab, navigation, it) {
				if(it==1) {	
					drawMinMap();
					$('#rootwizard').find('.pager .finish').show();
					$('#rootwizard').find('.pager .finish').removeClass('hidden');
					$('#rootwizard').find('.pager .next').hide();
				}
				else {
					$('#rootwizard').find('.pager .finish').hide();
					$('#rootwizard').find('.pager .finish').addClass('hidden');
					$('#rootwizard').find('.pager .next').show();
				}
				

				
			}
		});	

		$('#rootwizard').bootstrapWizard('first');		
	
	});
	
	//setTypeahead('#searchRegion', 'getRegiones', 'id', 'region','hiddenRegionID');
	
	//
	
	// $('#polygon_main_add').on('click', function(){		
		// if(typeof(xZona) != 'undefined') {
			// xZona.setMap(null);
		// }
		// function get_random_value(val_max) {
            // val_max = val_max || 100;
            // return Math.floor((Math.random()*val_max));
        // }		
		// var px_center = minmap.getCenter();		
		// var polygon_width = 300;
        // var polygon_height = 200;
        // var px_bl_x = parseInt(px_center.k - (0)) - 0.1;
        // var px_bl_y = parseInt(px_center.B + (0)) - 0.1;
        // var px_br_x = parseInt(px_center.k + (0)) + 0.1;
        // var px_br_y = parseInt(px_center.B + (0)) - 0.1;        
        // var px_tr_x = parseInt(px_center.k + (0)) + 0.1;
        // var px_tr_y = parseInt(px_center.B - (0)) + 0.1;        
        // var px_tl_x = parseInt(px_center.k - (0)) - 0.1;
        // var px_tl_y = parseInt(px_center.B - (0)) + 0.1;		
		// var triangleCoords = [
			// new google.maps.LatLng(px_bl_x, px_bl_y),
			// new google.maps.LatLng(px_br_x, px_br_y),
			// new google.maps.LatLng(px_tr_x, px_tr_y),
			// new google.maps.LatLng(px_tl_x, px_tl_y)
		// ];		
		// xZona = new google.maps.Polygon({
			// paths: triangleCoords,
			// draggable: true,
			// editable: true,			
			// strokeColor: '#000000',
			// strokeOpacity: 0.5,
			// strokeWeight: 2,
			// fillColor: '#CACACA',
			// fillOpacity: 0.7,
			// zIndex: 3
		// });				
		// xZona.setMap(minmap);		
    // });
	
	
	
	
	$('#tabZonas_ a').click(function (e) {
		e.preventDefault();
		window.location.href='/geologic/zonas';
	});

	
	

});

function drawX() {
	zonasPol = new Array();
	var markerBounds = new google.maps.LatLngBounds();
	$.each(ZS.zonas , function(index, value) {
		zonasPol[index] = new Array();
		zonasPol[index]['coords'] = new Array();
		$.each(value.coords , function(ix, vx) {
			zonasPol[index]['coords'].push( new google.maps.LatLng(vx['lat'], vx['lng']) );
			lat = vx['lat'];
			Lng = vx['lng'];
			markerBounds.extend(new google.maps.LatLng(lat, Lng));						
			map.fitBounds(markerBounds);
				
		});
		zonasPol[index]['zmap'] = new google.maps.Polygon({
									paths: zonasPol[index]['coords'],
									draggable: false,
									editable: false,
									strokeColor: '#' + value.color,
									strokeOpacity: 0.8,
									strokeWeight: 1,
									fillColor: '#' + value.color ,
									fillOpacity: 0.3,
									zIndex: 0
								});	
		zonasPol[index]['zmap'].setMap(map);

	});
	
	$.each(ZS.yacimientos , function(index, value) {
		
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(value['lat'],value['lng']),
			map: map,
			title: 'Hello World!'
		});
		
	});


	
	

}

function getInfo() {
	
	$('#infoRow h4').html('Zona ' + data.zona + ' ( Región ' + data.region + ' )');
	var markerBounds = new google.maps.LatLngBounds();

	$.each(zonasPol , function(index, value) {
		if (value.id == data.id) {
			var teta = google.maps.geometry.spherical.computeArea(value['zmap'].getPath());
			$('#infoRow p').html('Area: ' + teta.round(2) + ' mts2' );
			vertices=value['zmap'].getPath();
			
			for (i = 0; i < vertices.length; i++) {
				lng=(vertices.getAt(i).lng());
				lat=(vertices.getAt(i).lat());
				markerBounds.extend( new google.maps.LatLng(lat, lng) );						
				map.fitBounds(markerBounds);
			}
		}
	});
}

function drawRegiones() {
	regionesPol = new Array();
	zonasPol = new Array();
	var markerBounds = new google.maps.LatLngBounds();
	$.each(ZS.regiones , function(index, value) {
		regionesPol[index] = new Array();
		regionesPol[index]['coords'] = new Array();
		$.each(value.coords , function(ix, vx) {
			regionesPol[index]['coords'].push( new google.maps.LatLng(vx['lat'], vx['lng']) );
			lat = vx['lat'];
			Lng = vx['lng'];
			markerBounds.extend(new google.maps.LatLng(lat, Lng));						
			map.fitBounds(markerBounds);
				
		});
		regionesPol[index]['zmap'] = new google.maps.Polygon({
									paths: regionesPol[index]['coords'],
									draggable: false,
									editable: false,
									strokeColor: '#' + value.color,
									strokeOpacity: 0.8,
									strokeWeight: 1,
									fillColor: '#' + value.color ,
									fillOpacity: 0.3,
									zIndex: 0
								});	
		regionesPol[index]['zmap'].setMap(map);
		
		
		$.each(ZS.zonas , function(indexx, valuex) {
			if ((valuex.region_id == value.id) && (valuex.coords.length > 0)) {
				zonasPol[indexx] = new Array();
				zonasPol[indexx]['id'] = valuex.id;
				zonasPol[indexx]['name'] = valuex.name;
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
											strokeWeight: 1,
											fillColor: '#ff2012',
											fillOpacity: 0.4,
											zIndex: 1
										});	
				zonasPol[indexx]['zmap'].setMap(map);
				
			}
		});
			
		
	});


}

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
					$.map(data, function(data){					
						var group;
						group = {
							id: data[dataId],
							descriptionField: data[dataProperty],                          
							toString: function () {
								return JSON.stringify(this);
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
			//gotoRegion(item.id);
			//alert(item.id);
			return item.descriptionField;
		}
	});
}

var minmapOptions = {
	streetViewControl: false,
	zoom: 3,
	center: myLatLng,
	mapTypeId: google.maps.MapTypeId.HYBRID,
	disableDefaultUI: true
};

var minmap;

function drawMinMap() {
	
	minmap = new google.maps.Map(document.getElementById('mini-map'),minmapOptions);
	minmap.setZoom(1);
	minmap.panTo(myLatLng);

	gotoRegion($('#hiddenRegionID').val());

}

var minZonasPol;
var minRegionPol;

function gotoRegion(regId) {	
	
	if(typeof(xZona) != 'undefined') {
			xZona.setMap(null);
	}
		
	$.each(ZS.regiones, function(index, value) {		
		if (value.id == regId) {
			minZonasPol = null;
			if(typeof(minRegionPol) != 'undefined') {
				minRegionPol.setMap(null);
			}		
			var regionCoords = [];
			$.each(value.coords , function(indexx, valuex) {
				regionCoords.push(new google.maps.LatLng(valuex['lat'], valuex['lng']));				
			});			
			minRegionPol = new google.maps.Polygon({
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
			minRegionPol.setMap(minmap);				
			var latLng = new google.maps.LatLng(value.c_lat, value.c_lng); //Makes a latlng
			minmap.setZoom(value.c_zoom);
			minmap.panTo(latLng);

			minZonasPol = new Array();
			$.each(ZS.zonas , function(indexx, valuex) {
				if ((valuex.region_id == value.id) && (valuex.coords.length > 0)) {
					minZonasPol[indexx] = new Array();
					minZonasPol[indexx]['coords'] = new Array();
					$.each(valuex.coords , function(indexxx, valuexx) {
						minZonasPol[indexx]['coords'].push( new google.maps.LatLng(valuexx['lat'], valuexx['lng']) );						
					});
					minZonasPol[indexx]['zmap'] = new google.maps.Polygon({
												paths: minZonasPol[indexx]['coords'],
												draggable: false,
												editable: false,
												strokeColor: '#ff2012',
												strokeOpacity: 0.8,
												strokeWeight: 2,
												fillColor: '#ff2012',
												fillOpacity: 0.5,
												zIndex: 1
											});	
					minZonasPol[indexx]['zmap'].setMap(minmap);
					
					google.maps.event.addListener(minZonasPol[indexx]['zmap'], 'click', function(event) {
						
						var infowindow = new google.maps.InfoWindow();
						var contentString = '<div id="content" style="width:250px; height: 100px;">'+
							'Zona ' + valuex.name + '<br>' + 
							'Area: ' + google.maps.geometry.spherical.computeArea(minZonasPol[indexx]['zmap'].getPath()) + ' mts2' + 							
						  '</div>';

						infowindow.setContent(contentString);
						infowindow.setPosition(event.latLng);
						infowindow.open(minmap);
					});
					
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
