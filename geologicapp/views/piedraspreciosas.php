<style>

	#piedraspreciosasGrid {
		border: 0 none;
	}
	
	#piedraspreciosasGrid th, #piedraspreciosasGrid td {
		border-right: 0 none;
		border-left: 0 none;
	}
	
	.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
		border-bottom-width: 0;	
	}
	
	#piedraspreciosasGrid tbody tr.odd.selected, #piedraspreciosasGrid tbody tr.odd.selected {
		background-color: #abb9d3 !important;
	}
	
	.article {
		background-color: #ffffff;
		border: 1px solid #dddddd;
		border-radius: 5px;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.15) inset, 0 1px 5px rgba(0, 0, 0, 0.075);
		margin: 10px 5px;
		padding: 10px 15px;
	}

</style>

<div class="row">
	<div class="row" style="margin-top: 22px;">
		<div class="col-lg-12">
			<ul class="nav nav-tabs" role="tablist">
				<li id="tabZonas_"><a href="#tabZonas" role="tab" data-toggle="tab">Zonas</a></li>
				<li id="tabYacimientos_"><a href="#tabYacimientos" role="tab" data-toggle="tab">Yacimientos</a></li>
				<li id="tabMinerales_"><a href="#tabMinerales" role="tab" data-toggle="tab">Minerales</a></li>
				<li id="tabPP_" class="active"><a href="#tabPP" role="tab" data-toggle="tab">Piedras Preciosas</a></li>				
			</ul>
		</div>
	</div>
	<div class="row tab-content" style="margin-top: 12px;">
		<div class="tab-pane active" id="tabPP">
			<div class="col-lg-6">
				<div style="">
					<!--
					<a href="/geologic/zonas/create" class="btn btn-warning btn-sm btn-newP" style="float:left;">
						Nueva Zona
					</a>
					-->
					<button type="button" class="btn btn-warning btn-sm btn-newP" data-toggle="modal" data-target="#myModal" style="float:left;">
						Nueva Piedra Preciosa 
					</button>
					<div style="clear: both; float: left; margin-top: 10px;">
						<button type="button" class="btn btn-default btn-xs">
							<span class="glyphicon glyphicon-fire"></span> Vista General
						</button>
					</div>
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Nueva Pidra Preciosa</h4>
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
									<?php echo form_open("/piedraspreciosas/create", array('name' => 'newPP_form', 'id' => 'newPP_form'));?>
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
													<p>Ingrese los datos necesarios para la nueva Piedra Preciosa</p>
													<div class="col-lg-12">
														<div class="form-group input-group col-lg-6">
															<span class="input-group-addon">Yacimiento</span>
															<input type="text" class="form-control" name="yacimiento" id="yacimiento" placeholder="Yacimiento">
														</div>
														<div class="form-group input-group col-lg-6">
															<span class="input-group-addon">Zona</span>
															<input type="text" name="searchZona" id="searchZona" data-provide="typeahead" class="form-control" autocomplete="off" placeholder="Zona" />
															<input type="hidden" name="hiddenZonaID" id="hiddenZonaID"/>
															<div id="infoSelZona" style="display: none; position: absolute; font-size: 11px; top: 40px;">
																<span>Selección:</span>
																<span id="selZona" style="font-weight: bold;"></span> 
															</div>
														</div>
														<div  id="datetimepicker1" class="form-group input-group col-lg-6 calendar" data-date-format="DD/MM/YYYY">
															<span class="input-group-addon">Fecha desc.</span>
															<input type="text" class="form-control" id="fechaDescubrimiento" name="fechaDescubrimiento"/>
															<span class="input-group-addon" style="width: 40px !important;">
																<span class="glyphicon-calendar glyphicon"></span>
															</span>													
														</div>
														
													</div>
												</div>
												<div class="tab-pane" id="tab2">
													<p>Ubicar una posición para insertar la nueva zona</p> 
													<a id="point_add">Insertar</a>
													<div id="mini-map" style="height: 350px; width: auto;">
													</div>
													<input type="hidden" id="coord" name="coord" value="" >
												</div>
												<div class="tab-pane" id="tab3">
													<p>Declarar un mineral</p>
													
													<div class="form-group input-group col-lg-6">
														<span class="input-group-addon">Mineral</span>
														<select class="form-control" name="minerales" id="mineral">
															<?php foreach( $minerales_tipo as $tipo ) : ?>
																<option value="<?=$tipo->id ?>"><?=$tipo->nombre ?></option>
															<?php endforeach; ?>
														</select>
													</div>
													<div class="form-group input-group col-lg-4">
														<span class="input-group-addon">Dureza</span>
														<input type="text" class="form-control" name="dureza" id="dureza" placeholder="Dureza">
													</div>
													<div class="form-group input-group col-lg-4">
														<span class="input-group-addon">Densidad</span>
														<input type="text" class="form-control" name="densidad" id="densidad" placeholder="Densidad">
													</div>
													<div class="form-group input-group col-lg-12">
														<span class="input-group-addon">Característica</span>
														<input type="text" class="form-control" name="caracteristicas" id="caracteristicas" placeholder="Características">
													</div>
													<div class="form-group input-group col-lg-4">
														<span class="input-group-addon">Explotabilidad</span>
														<input type="text" class="form-control" name="explotabilidad" id="explotabilidad" placeholder="Explotabilidad">
													</div>
													<div class="form-group input-group col-lg-4">
														<span class="input-group-addon">Explotacion</span>
														<input type="text" class="form-control" name="explotacion" id="explotacion" placeholder="Explotacion">
													</div>
																						
													
												</div>
												<ul class="pager wizard">
													<li class="first" style="display:none;"><a href="#">Prim.</a></li>
													<li class="previous"><a href="#">Ant.</a></li>
													<li class="last" style="display:none;"><a href="#">Ult.</a></li>
													<li class="next"><a href="#">Sig.</a></li>
													<li class="finish" style="display:none;float:right;"><a href="#">Guardar</a></li>
												</ul> 
											</div>	
										</div>
									<?php echo form_close();?>	
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
				<div id="map-canvas" style="height: 400px; width: auto; margin-top: 11px;">
				</div>
			</div>
			<div class="col-lg-6">
				<table id="piedraspreciosasGrid" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th>Nombre</th>
							<th>Fecha Desc.</th>							
							<th>Zona</th> 
							<th>Acciones</th>
						</tr>
					</thead>					
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<div id="infoRow" class="article">
			<h4></h4>
			<p>
				
			</p>
		</div>
	</div>
</div>

<script>

var ZS = ZS || {};
    ZS.zonas = [<?php foreach( $zonas as $zona ) : ?>
		{id : <?=$zona['zona']->id ?>,
		 name : "<?=$zona['zona']->zona ?>",
		 region_id: <?=$zona['zona']->region_id ?>,
		 coords :[<?php foreach( $zona['coordenadas'] as $coord ) : ?>{"lat":"<?=$coord->lat ?>","lng":"<?=$coord->lng ?>"},<?php endforeach; ?>]
		},<?php endforeach; ?>];
	 
	ZS.piedraspreciosas = [<?php foreach( $piedraspreciosas as $piedraspreciosa ) : ?>{<?php foreach( $piedraspreciosa as $key => $value ) : ?><?=$key ?> : "<?=$value ?>",<?php endforeach; ?>},<?php endforeach; ?>];
	
</script>




