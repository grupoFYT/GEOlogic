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
var datax;

var xMaker;

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
	
	table = $('#piedraspreciosasGrid').DataTable( {
		
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "/geologic/piedraspreciosas/datatable",
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
			{ "data": "nombre" },
			{ "data": "fecha_descubrimiento" },
			{ "data": "zona" },
			{ "data": null,
			  "orderable":      false,
			  "searchable":     false,
			  "render": function ( data, type, row ) {
                    return '<a class="btn btn-danger btn-xs" href="/geologic/piedraspreciosas/delete/' + data.id + '">Eliminar</a>';
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
	
	$('#piedraspreciosasGrid tbody').on( 'click', 'tr', function () {

		datax = table.row( this ).data();
		getInfo();
		
	} );
		
	// Search Button
			
	$('#searchButton').click(function() {
		if ($('#searchInput').val().trim().length < 4) {
			$('#searchInput').val("");
		}
		$('#piedraspreciosasGrid').DataTable().search($('#searchInput').val().trim()).draw();
	});
	
		
	
	$('#tabZonas_ a').click(function (e) {
		e.preventDefault();
		window.location.href='/geologic/zonas';
	});
	
	$('#tabYacimientos_ a').click(function (e) {
		e.preventDefault();
		window.location.href='/geologic/yacimientos';
	});
	$('#tabMinerales_ a').click(function (e) {
		e.preventDefault();
		window.location.href='/geologic/minerales';
	});
	$('#tabPP_ a').click(function (e) {
		e.preventDefault();
		window.location.href='/geologic/piedraspreciosas';
	});	
	
});

function getInfo() {	
	// var markerBounds = new google.maps.LatLngBounds();

	$.each(ZS.piedraspreciosas , function(index, value) {
		if (value.id == datax.id) {
			$('#infoRow h4').html(value.nombre + ' ( Zona ' + datax.zona + ' )');
			
			map.setZoom(10);
			map.panTo(new google.maps.LatLng(value.lat, value.lng));
			
			$.each(value.minerales , function(indexx, valuex) {
				$('#infoRow p').html(valuex.nombre + '<br>');
			
			});
			
		}
	});
}
	
	
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
	
	$.each(ZS.piedraspreciosas , function(index, value) {
		
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(value['lat'],value['lng']),
			map: map,
			title: value.nombre
		});
		
	});

}