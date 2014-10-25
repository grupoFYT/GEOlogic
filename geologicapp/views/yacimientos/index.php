<?php if($this->session->flashdata('item')) { ?> 
<div class="alert alert-success"> 
<?php echo $this->session->flashdata('item'); ?> 
</div> 
<?php } ?>

<div class="col-lg-8">
	<div class="panel panel-default">

		<div class="gridPanel">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-6">
						<div class="input-group custom-search-form" >
							<input id="searchInput" type="text" placeholder="Busqueda..." class="form-control" >
							<span class="input-group-btn">
								<button id="searchButton" type="button" class="btn btn-default">
									<i class="fa fa-search"></i>
								</button>
								
							</span>
						</div>
					</div>
					<div class="col-lg-6">					
						<a class="btn btn-warning btn-sm btn-newP" href="/geologic/yacimientos/create">
							Nuevo yacimiento
						</a>
					</div>
				</div>			
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<style type="text/css" class="init">

				td.details-control {
					background: url('<?= base_url() ?>assets/images/details_open.png') no-repeat center center;
					cursor: pointer;
				}
				tr.shown td.details-control {
					background: url('<?= base_url() ?>assets/images/details_close.png') no-repeat center center;
				}
				
				#yacimientosGrid tbody td:nth-child(2) {
					text-align: center;
				}
				
				#yacimientosGrid tbody td:nth-child(5) {
					text-align: center;
				}
				
				#yacimientosGrid tbody td:nth-child(6) {
					text-align: center;
				}
				
				#yacimientosGrid tbody td:nth-child(7) {
					text-align: center;
				}
				
				#yacimientosGrid tr th {
					text-align: center;
				}
				
				.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
					border: 0px !important;
				}
				
				#yacimientosGrid_filter {
					display: none;
				}

				</style>
				
				<table id="yacimientosGrid" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th>Yacimiento</th>
							<th>Fecha Descubrimiento</th>
							<th>Zona</th>
							<th>Acciones</th>
						</tr>
					</thead>
					
				</table>
				
			</div>
		<!-- /.panel-body -->
		</div>
	</div>
	<!-- /.panel -->

</div>
