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
						<a class="btn btn-warning btn-sm btn-newP" href="/geologic/zonas/create">
							Nueva Zona
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
				
				#zonasGrid tbody td:nth-child(2) {
					text-align: center;
				}
				
				#zonasGrid tbody td:nth-child(5) {
					text-align: center;
				}
				
				#zonasGrid tbody td:nth-child(6) {
					text-align: center;
				}
				
				#zonasGrid tbody td:nth-child(7) {
					text-align: center;
				}
				
				#zonasGrid tr th {
					text-align: center;
				}
				
				.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
					border: 0px !important;
				}
				
				#zonasGrid_filter {
					display: none;
				}

				</style>
				
				<table id="zonasGrid" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th>Zona</th>
							<th>Region</th>
							<th>Pais</th>
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
<!-- /.col-lg-8 -->
<div class="col-lg-4">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-bell fa-fw"></i> Notificaciones
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="list-group">
				<a href="#" class="list-group-item">
					<i class="fa fa-comment fa-fw"></i> Nuevo comentario
					<span class="pull-right text-muted small"><em>9:45 AM</em>
					</span>
				</a>
				<a href="#" class="list-group-item">
					<i class="fa fa-comment fa-fw"></i> Nuevo comentario
					<span class="pull-right text-muted small"><em>9:26 AM</em>
					</span>
				</a>                                
			</div>
			<!-- /.list-group -->
			<a href="#" class="btn btn-default btn-block">Todas las notificaciones</a>
		</div>
		<!-- /.panel-body -->
	</div>
	<!-- /.panel -->
	<div class="chat-panel panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-comments fa-fw"></i>
			Chat
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-chevron-down"></i>
				</button>
				<ul class="dropdown-menu slidedown">
					<li>
						<a href="#">
							<i class="fa fa-refresh fa-fw"></i> Refresh
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-check-circle fa-fw"></i> Available
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-times fa-fw"></i> Busy
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-clock-o fa-fw"></i> Away
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<i class="fa fa-sign-out fa-fw"></i> Sign Out
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<ul class="chat">
				<li class="left clearfix">
					<span class="chat-img pull-left">
						<img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle" />
					</span>
					<div class="chat-body clearfix">
						<div class="header">
							<strong class="primary-font">Ale</strong> 
							<small class="pull-right text-muted">
								<i class="fa fa-clock-o fa-fw"></i> 9:47 AM
							</small>
						</div>
						<p>
							Bla bla bla bla
						</p>
					</div>
				</li>
				<li class="right clearfix">
					<span class="chat-img pull-right">
						<img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar" class="img-circle" />
					</span>
					<div class="chat-body clearfix">
						<div class="header">
							<small class=" text-muted">
								<i class="fa fa-clock-o fa-fw"></i> 9.45</small>
							<strong class="pull-right primary-font">Lorenzo</strong>
						</div>
						<p>
							Ble ble ble
						</p>
					</div>
				</li>
				<li class="left clearfix">
					<span class="chat-img pull-left">
						<img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle" />
					</span>
					<div class="chat-body clearfix">
						<div class="header">
							<strong class="primary-font">Tito</strong> 
							<small class="pull-right text-muted">
								<i class="fa fa-clock-o fa-fw"></i> 9:42</small>
						</div>
						<p>
							Turu turu rutu
						</p>
					</div>
				</li>
			</ul>
		</div>
		<!-- /.panel-body -->
		<div class="panel-footer">
			<div class="input-group">
				<input id="btn-input" type="text" class="form-control input-sm" placeholder="Enviar mensaje..." />
				<span class="input-group-btn">
					<button class="btn btn-warning btn-sm" id="btn-chat">
						Enviar
					</button>
				</span>
			</div>
		</div>
		<!-- /.panel-footer -->
	</div>
	<!-- /.panel .chat-panel -->
</div>