<style>

	#zonasGrid {
		border: 0 none;
	}
	
	#zonasGrid th, #zonasGrid td {
		border-right: 0 none;
		border-left: 0 none;
	}
	
	.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
		border-bottom-width: 0;	
	}
	
	#zonasGrid tbody tr.odd.selected, #zonasGrid tbody tr.odd.selected {
		background-color: #abb9d3 !important;
	}

</style>


<div class="row">
	<div class="row" style="margin-top: 22px;">
		<div class="col-lg-12">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#tabZonas" role="tab" data-toggle="tab">Zonas</a></li>
				<li><a href="#tabMinerales" role="tab" data-toggle="tab">Minerales</a></li>
				<li><a href="#tabPP" role="tab" data-toggle="tab">Piedras Preciosas</a></li>
				<li><a href="#tabYacimientos" role="tab" data-toggle="tab">Yacimientos</a></li>
			</ul>
		</div>
	</div>
	<div class="row tab-content" style="margin-top: 12px;">
		<div class="tab-pane active" id="tabZonas">
			<div class="col-lg-6">
				<div style="">
					<!--
					<a href="/geologic/zonas/create" class="btn btn-warning btn-sm btn-newP" style="float:left;">
						Nueva Zona
					</a>
					-->
					<button type="button" class="btn btn-warning btn-sm btn-newP" data-toggle="modal" data-target="#myModal" style="float:left;">
						Nueva Zona
					</button>
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Nueva Zona</h4>
								</div>
								<div class="modal-body">
									<div id="rootwizard">
										<div class="tab-content">
											<div class="tab-pane" id="tab1">
											  1
											</div>
											<div class="tab-pane" id="tab2">
											  2
											</div>
											<div class="tab-pane" id="tab3">
												3
											</div>
											<div class="tab-pane" id="tab4">
												4
											</div>
											<div class="tab-pane" id="tab5">
												5
											</div>
											<div class="tab-pane" id="tab6">
												6
											</div>
											<div class="tab-pane" id="tab7">
												7
											</div>
											<ul class="pager wizard">
												<li class="previous first" style="display:none;"><a href="#">First</a></li>
												<li class="previous"><a href="#">Previous</a></li>
												<li class="next last" style="display:none;"><a href="#">Last</a></li>
												<li class="next"><a href="#">Next</a></li>
											</ul>
										</div>	
									</div>
								</div>
								<!--
								<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-primary">Guardar</button>
								</div>
								-->
							</div>
						</div>
					</div>

				</div>
				<div style="clear:both;">
					
				</div>
				<div id="map-canvas" style="height: 400px; width: auto; margin-top: 13px;">
				</div>
			</div>
			<div class="col-lg-6">
				<table id="zonasGrid" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th>Zona</th>
							<th>Region</th>
							<th>Pais</th>
							<th>Acciones</th>
						</tr>
					</thead>					
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div id="infoRow" class="col-lg-12">info adsfghasfg
		</div>
	</div>
</div>

<script>

var ZS = ZS || {};
	ZS.regiones = [<?php foreach( $regiones as $region ) : ?>
		{id : <?=$region['region']->id ?>,
		 name : "<?=$region['region']->region ?>",
		 color: "<?=$region['region']->color ?>",
		 c_lat: <?=$region['region']->c_lat ?>,
		 c_lng: <?=$region['region']->c_lng ?>,
		 c_zoom: <?=$region['region']->c_zoom ?>,
		 coords :[<?php foreach( $region['coordenadas'] as $coord ) : ?>{"lat":"<?=$coord->lat ?>","lng":"<?=$coord->lng ?>"},<?php endforeach; ?>]
		},<?php endforeach; ?>];
    ZS.zonas = [<?php foreach( $zonas as $zona ) : ?>
		{id : <?=$zona['zona']->id ?>,
		 name : "<?=$zona['zona']->zona ?>",
		 region_id: <?=$zona['zona']->region_id ?>,
		 coords :[<?php foreach( $zona['coordenadas'] as $coord ) : ?>{"lat":"<?=$coord->lat ?>","lng":"<?=$coord->lng ?>"},<?php endforeach; ?>]
		},<?php endforeach; ?>];
	
</script>


