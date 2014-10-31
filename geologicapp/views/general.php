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
									<style>
										#rootwizard .navbar {
											display: none;
										}
										
										.input-group-addon {
											text-align: right;
											width: 111px;
										}
									</style>									
									<div id="rootwizard">
										<div class="navbar">
											<div class="navbar-inner">
												<div class="container">
													<ul>
														<li><a href="#tab1" data-toggle="tab">1</a></li>
														<li><a href="#tab2" data-toggle="tab">2</a></li>
														<li><a href="#tab3" data-toggle="tab">3</a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="tab-content">
											<div class="tab-pane" id="tab1">
												<p>Ingrese una denominación y seleccione la región para la nueva zona</p>
												<div class="col-lg-12">
													<div class="form-group input-group col-lg-6">
														<span class="input-group-addon">Zona</span>
														<input type="text" class="form-control" name="zona" id="zona" placeholder="Zona">
													</div>
													<div class="form-group input-group col-lg-6">
														<span class="input-group-addon">Región</span>
														<input type="text" name="searchRegion" id="searchRegion" data-provide="typeahead" class="form-control" autocomplete="off" placeholder="Region" />
														<input type="hidden" name="hiddenRegionID" id="hiddenRegionID"/>
														<div id="infoSelRegion" style="display: none; position: absolute; font-size: 11px; top: 40px;">
															<span>Selección:</span>
															<span id="selRegion" style="font-weight: bold;"></span> 
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="tab2">
												<p>Ubicar una posición para insertar la nueva zona</p>
												<a id="polygon_main_add">Insertar</a>
												<div id="mini-map" style="height: 350px; width: auto;">
												</div>
											</div>
											<div class="tab-pane" id="tab3">
												3
											</div>
											<ul class="pager wizard">
												<li class="previous first" style="display:none;"><a href="#">Prim.</a></li>
												<li class="previous"><a href="#">Ant.</a></li>
												<li class="next last" style="display:none;"><a href="#">Ult.</a></li>
												<li class="next"><a href="#">Sig.</a></li>
												<li class="finish" style="display:none;"><a href="#">Guardar</a></li>
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


