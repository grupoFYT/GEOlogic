<?php $this->load->view('_blocks/headerAuth'); ?>
<div id="content" class="container">
    
    <p class="pull-right"><a class="btn btn-default" href="<?php echo base_url('auth'); ?>">Volver</a></p>
    <p><?php echo lang('create_group_subheading'); ?></p>

    <?php if(!empty($message)) echo '<div id="infoMessage" class="alert alert-warning"><i class="fa fa-warning"></i> '.$message.'</div>';?>

    <?php echo form_open("auth/create_center", array('class' => 'form-horizontal')); ?>

        <div class="form-group">
            <?php echo form_label('Nombre', 'center_name', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-3"><?php echo form_input($center_name, NULL, 'class="form-control"'); ?></div>
        </div>

        <div class="form-group">
            <?php echo form_label('Descripción', 'description', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-3"><?php echo form_input($description, NULL, 'class="form-control"'); ?></div>
        </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10"><?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-primary btn-large', 'value' => 'Crear')); ?></div>
    </div>
    <?php echo form_close(); ?>


<?php $this->load->view('_blocks/footerAuth'); ?>
