var myLatLng = new google.maps.LatLng(-36.000, -64.000);
var mapOptions = {
	zoom: 3,
	center: myLatLng,
	mapTypeId: google.maps.MapTypeId.HYBRID
};

var map;
var regionPol;
var zonasPol;

google.maps.Polygon.prototype.my_getBounds=function(){
    var bounds = new google.maps.LatLngBounds()
    this.getPath().forEach(function(element,index){bounds.extend(element)})
    return bounds
}

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
		
		var markerBounds = new google.maps.LatLngBounds();
		$.each(zonasPol , function(index, value) {
			if (value.id == data.id) {
				var x = value['zmap'].my_getBounds().getCenter();				
				var latLng = new google.maps.LatLng(x.k, x.B);
				markerBounds.extend(latLng);
				map.fitBounds(markerBounds);
				map.panTo(latLng);
				
				//
				
				var xc = map.getBounds();
				var xsdd = xc.getNorthWest();
				var sfghdsfh = xsdd.lat();
				alert(sfghdsfh);
				alert(map.getBounds().getNorthWest().lat());
				
				var visiblemap = new google.maps.Polygon({
					paths: [
							new google.maps.LatLng(map.getBounds().getNorthWest().lat(), map.getBounds().getNorthWest().lng()),
							new google.maps.LatLng(map.getBounds().getNorthEast().lat(), map.getBounds().getNorthEast().lng()),
							new google.maps.LatLng(map.getBounds().getSouthEast().lat(), map.getBounds().getSouthEast().lng()),
							new google.maps.LatLng(map.getBounds().getSouthWest().lat(), map.getBounds().getSouthWest().lng()),
							new google.maps.LatLng(map.getBounds().getNorthWest().lat(), map.getBounds().getNorthWest().lng())
							]
				});
				
				var area = google.maps.geometry.spherical.computeArea(visiblemap.getPath());
				alert(area);
				
				// var scale = Math.pow(2, map.getZoom());
				// var nw = new google.maps.LatLng(
					// map.getBounds().getNorthEast().lat(),
					// map.getBounds().getSouthWest().lng()
				// );
				// var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
				// var worldCoordinate = map.getProjection().fromLatLngToPoint(marker.getPosition());
				// var pixelOffset = new google.maps.Point(
					// Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
					// Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
				// );
				
				
				
				
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
											fillOpacity: 0.5,
											zIndex: 1
										});	
				zonasPol[indexx]['zmap'].setMap(map);
				
			}
		});
			
		
	});


}


