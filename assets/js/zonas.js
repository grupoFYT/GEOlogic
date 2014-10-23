
function format ( d ) {

	//alert(d);
    
	return 	'<div class="peopleinfoContent"><div class="thumb"><img alt="" src="/assets/images/nothumb.png"></div>' +
			'<div class="peopleinfo"><h4><a href="">' + d.id + ' ' + d.id + '</a></h4>' +
				'<ul>' +
					'<li><span></span> ' + d.id + '</li>' +
					'<li><span></span></li>' +
				'</ul>' +
				'<a class="btn btn-info btn-rounded" href="/geologic/zonas/delete/' + d.id +
				((d.id == 1) ? '"><i class="fa fa-check fa-fw" style="color:green;"></i>' : '"><i class="fa fa-warning fa-fw" style="color:red;"></i>') +
				' Eliminar</a>' +
			'</div></div>';
	
	
}


$(document).ready(function() {

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
                 "class":          'details-control',
                 "orderable":      false,
                 "data":           null,
                 "defaultContent": '',
				 "searchable":     false
             },
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
                    return 'hola';
				},
			},
		],
		"language": {
			"lengthMenu": "Mostrando _MENU_ zonas por pagina",
			"zeroRecords": "No se han encontrado resultados",
			"info": "Pag. _PAGE_ de _PAGES_",
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
	
    $('#zonasGrid tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
	
	// Search Button
			
	$('#searchButton').click(function() {
		if ($('#searchInput').val().trim().length < 4) {
			$('#searchInput').val("");
		}
		$('#zonasGrid').DataTable().search($('#searchInput').val().trim()).draw();
	});
	
	
} );

