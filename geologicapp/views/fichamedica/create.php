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

.checkbox {
	margin-left:10px;
}


</style>



<address style="margin-left: 20px;">
  <strong><?=$paciente->apellido?>, <?=$paciente->nombres?></strong> <?= (($paciente->sexo == "M")?'(Masculino)':'(Femenino)') ?><br>
  DNI. <?=$paciente->dni?><br>
  Fecha Nac. <?=$paciente->fechaNacimiento?><br>
  
</address>
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-user fa-fw" style="color: #428bca;"></i> Ficha Médica
		</div>
		<div class="panel-body">
			<!-- http://startbootstrap.com/templates/sb-admin-v2/ -->
			<?php echo form_open("/pacientes/create", array('class' => 'row form-newP', 'name' => 'newP_form', 'id' => 'newP_form'));?>
			
				<div class="col-lg-6">
					<div class="form-group">
						<label>Tipo de discapacidad</label>
						<p class="help-block">Seleccione los tipos de discapacidad correspondintes.</p>
						
						<div class="checkbox">
							<label>
								<input type="checkbox" name="td" value="1">Mental
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="td" value="2">Motora
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="td" value="3">Auditiva
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="td" value="4">Visual
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="td" value="5">Visceral
							</label>
						</div>
						
					</div>
					
					<div class="form-group">
						<label>Diagnosticos Etiológicos</label>
						<p class="help-block">Seleccione diagnosticos etiológicos según CIE10.</p>
						<input type="text" placeholder="Diagnosticos Etiológicos" id="diagnosticosE" name="diagnosticosE" class="form-control" />		
					</div>
					<div class="form-group">
						<label>Diagnosticos Funcionales</label>
						<p class="help-block">Seleccione diagnosticos funcionales según CIDIM.</p>
						<input type="text" placeholder="Diagnosticos Etiológicos" id="diagnosticosF" name="diagnosticosF" class="form-control" />	
					</div>
					
					<style>
						.calendar table button {
							border: 0 none !important;
						}
					</style>
					
					<div class="form-group">
						<label>Fecha de inicio de la discapacidad</label>
						<p class="help-block">Indique la fecha de inicio de la discapacidad. Si no se ingresa ninguna, se considerará el ininio de la misma desde el nacimiento.</p>
							<div  id="datetimepicker1" class="form-group input-group col-lg-8 calendar" data-date-format="DD/MM/YYYY">
								<span class="input-group-addon">Inicio Disc.</span>
								<input type="text" class="form-control" id="fechaNacimiento" name="fechaNacimiento"/>
								<span class="input-group-addon" style="width: 40px !important;">
									<span class="glyphicon-calendar glyphicon"></span>
								</span>
								
							</div>
					</div>

					<div class="form-group input-group col-lg-8">
						<?php echo form_submit(array('name' => 'submit', 'value' => 'Guardar', 'class' => 'btn btn-primary', 'style' => 'margin-top:10px; margin-left: 115px; width: 115px;'));?>
					</div>
				</div>
				<div class="col-lg-6">
				
				</div>
			
			<?php echo form_close();?>	
			
		</div>
	</div>
</div>
<script type="text/javascript">
	var minDatex  = "<?=$paciente->fechaNacimiento?>";
</script>

