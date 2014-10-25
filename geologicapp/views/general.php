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
		background-color: #abb9d3;
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
					<a href="/geologic/zonas/create" class="btn btn-warning btn-sm btn-newP" style="float:left;">
						Nueva Zona
					</a>
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
		<div class="col-lg-12">info adsfghasfg
		</div>
	</div>
</div>

