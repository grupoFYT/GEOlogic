<?php if($this->session->flashdata('item')) { ?> 
<div class="alert alert-success"> 
<?php echo $this->session->flashdata('item'); ?> 
</div> 
<?php } ?>

<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class=""></i>
					</div>
					<div class="col-xs-9 text-right">
						<? ini_set('display_errors', 'On'); ?>
						<div class="huge"><?= count(Model\Zona::all()) ?></div>
						<div>Zonas</div>
					</div>
				</div>
			</div>
			<a href="zonas">
				<div class="panel-footer">
					<span class="pull-left">Zonas</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>


</div>