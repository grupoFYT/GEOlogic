<div class="row">

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
							<a class="btn btn-warning btn-sm btn-newP" href="/pacientes/create">
								Nuevo paciente
							</a>
						</div>
					</div>			
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				
					<table id="pacientesGrid" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th>DNI</th>
								<th>Apellido</th>
								<th>Nombres</th>
								<th>Sexo</th>
								<th>Fecha Nac.</th>
								<th></th>
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
			
		</div>

	</div>

</div>