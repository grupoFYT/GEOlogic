<?php $this->load->view('_blocks/headerAuth'); ?>
<div id="content" class="container">

<p>Lista de usuarios</p>

<?php if(!empty($message)) echo '<div id="infoMessage" class="alert alert-warning"><i class="fa fa-warning"></i> '.$message.'</div>';?>

<p><?php echo anchor('auth/create_user', lang('index_create_user_link'), array('class' => 'btn btn-default')); ?>
 &nbsp; <?php echo anchor('auth/create_group', 'Crear Rol' , array('class' => 'btn btn-default')); ?>

<table class="table table-striped table-hover">
    <thead>
	<tr>
		<th><?php echo lang('index_fname_th');?></th>
		<th><?php echo lang('index_lname_th');?></th>
		<th><?php echo lang('index_email_th');?></th>
		<th><?php echo lang('index_groups_th');?></th>
		<th>Estado</th>
		<th><?php echo lang('index_action_th');?></th>
	</tr>
    </thead>
    <tbody>
	<?php $i = 0; ?>
	<?php foreach ($users as $user):?>
		<tr>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
                <?php endforeach?>
			</td>
			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'), array('class' => 'btn btn-danger')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'), array('class' => 'btn btn-danger'));?></td>
			<td><?php echo anchor("auth/edit_user/".$user->id, 'Editar', array('class' => 'btn btn-primary')) ;?></td>
		</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach;?>
    </tbody>
</table>



<?php $this->load->view('_blocks/footerAuth'); ?>

