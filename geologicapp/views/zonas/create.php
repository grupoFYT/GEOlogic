<style type="text/css">
.form-control {
background-color: #ffffff;
border-radius: 2px;
border-style: solid;
border-width: 1px;
font-size: 14px;
margin-bottom: 5px;
outline: 0 none;
padding: 6px;
width: 95%;
}

.typeahead > li > a {
	padding: 3px 0 !important;
}

.help-block {
	margin-bottom: 10px;
    margin-left: 112px;
    margin-top: 0;
}

</style>

<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-user fa-fw"></i> Ficha Zona
		</div>
		<div class="panel-body">
			<!-- http://startbootstrap.com/templates/sb-admin-v2/ -->
			<?php echo form_open("/zonas/create", array('class' => 'row form-newP', 'name' => 'newP_form', 'id' => 'newP_form'));?>
			
				<div class="col-lg-6">
					<div class="form-group input-group col-lg-8">						
						<h5><i style="margin-right: 7px;color: #B94D4A;" class="fa fa-map-marker fa-2x"></i>Descripción de zona y localización</h5>
					</div>
					<div class="form-group input-group col-lg-8">
						<span class="input-group-addon">Zona</span>
						<input type="text" placeholder="Zona" id="zona" name="zona" class="form-control"/>
					</div>
				
					<div class="form-group input-group col-lg-8">
						<span class="input-group-addon">Región</span>
						<input type="text" name="searchRegion" id="searchRegion" data-provide="typeahead" class="form-control" autocomplete="off" placeholder="Region" />
						<input type="hidden" name="hiddenRegionID" id="hiddenRegionID"/>
						<div id="infoSelRegion" style="display: none; position: absolute; font-size: 11px; top: 40px;">
							<span>Selección:</span>
							<span id="selRegion" style="font-weight: bold;"></span> 
						</div>
					</div>
					<a id="polygon_main_add">Insertar</a>
					<div id="map-canvas" style="height: 350px; width: auto;">
					</div>
					<div id="info" style="position: absolute; font-family: Arial; font-size: 14px;">
					</div>
					<input type="hidden" id="coord" name="coord" value="" >
					
					<div class="form-group input-group col-lg-8">
						<?php echo form_submit(array('name' => 'submit', 'value' => 'Agregar', 'class' => 'btn btn-primary', 'style' => 'margin-top:10px; margin-left: 115px; width: 115px;'));?>
					</div>
				</div>
				<div class="col-lg-6">
				
				</div>
			
			<?php echo form_close();?>	
			
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


