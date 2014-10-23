
function format ( d ) {

	//alert(d);
    
	return 	'<div class="ppinfoContent">'+
			'<img style="border-radius: 5%;" class="" alt="' + d.mineral + '" src="/geologic/assets/images/minerales/' + (d.mineral).toLowerCase() + '.jpg">' +
			'</div>';
	
	
}


$(document).ready(function() {

	var table = $('#mineralesGrid').DataTable( {
		
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "/geologic/minerales/datatable",
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
			{ "data": "mineral" },
			{ "data": "dureza" },
			{ "data": "color" },
			{ "data": "densidad" },
			{ "data": "caracteristicas" },
			{ "data": "origen" },
			{ "data": "utilidad" },
			{ "data": null,
			  "orderable":      false,
			  "searchable":     false,
			  "render": function ( data, type, row ) {
                    return '<a class="btn btn-danger btn-xs" href="/geologic/minerales/delete/' + data.id + '">Eliminar</a>' + 
						   '<a class="btn btn-primary btn-xs" href="/geologic/minerales/delete/' + data.id + '">Ubicar</a>';
				},
			},
		],
		"language": {
			"lengthMenu": "Mostrando _MENU_ piedras por pagina",
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
	
    $('#mineralesGrid tbody').on('click', 'td.details-control', function () {
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
		$('#mineralesGrid').DataTable().search($('#searchInput').val().trim()).draw();
	});
	
	
} );

