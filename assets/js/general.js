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
	
	drawRegiones();
	
	var table = $('#zonasGrid').DataTable( {
		
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "/geologic/zonas/datatable",
			"type": "POST"
		},
		"lengthChange": false,
		"order": [[ 1, "desc" ]],
		"columns": [
			{ 
				"orderable":      false,
				"searchable":     false,
				"data": "id",
				"visible" : false
			},
			{ "data": "zona" },
			{ "data": "region" },
			{ "data": "pais" },
			{ "data": null,
			  "orderable":      false,
			  "searchable":     false,
			  "render": function ( data, type, row ) {
                    return '<a class="btn btn-danger btn-xs" href="/geologic/zonas/delete/' + data.id + '">Eliminar</a>';
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
	
	$('#zonasGrid tbody').on( 'click', 'tr', function () {
		var data = table.row( this ).data();
		
		$('#infoRow').html(data.zona + '<br>' + data.region);
		
		$.each(ZS.zonas , function(index, value) {
			if (value.id == data.id) {
				
				
				var latLng = new google.maps.LatLng(value.c_lat, value.c_lng);
				map.setZoom(value.c_zoom);
				map.panTo(latLng);
			}
		});	
		
		
		
	} );
		
	// Search Button
			
	$('#searchButton').click(function() {
		if ($('#searchInput').val().trim().length < 4) {
			$('#searchInput').val("");
		}
		$('#zonasGrid').DataTable().search($('#searchInput').val().trim()).draw();
	});
	
	
	
});

function drawRegiones() {

	regionesPol = new Array();
	zonasPol = new Array();
	$.each(ZS.regiones , function(index, value) {

		regionesPol[index] = new Array();
		regionesPol[index]['coords'] = new Array();
		$.each(value.coords , function(ix, vx) {
			regionesPol[index]['coords'].push( new google.maps.LatLng(vx['lat'], vx['lng']) );						
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
		var tettt = regionesPol[index]['zmap'].getBounds().getCenter();
		
		
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
											strokeWeight: 1,
											fillColor: '#ff2012',
											fillOpacity: 0.5,
											zIndex: 1
										});	
				zonasPol[indexx]['zmap'].setMap(map);
				
			}
		});
			
		
	});


}


