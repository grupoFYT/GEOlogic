
        </div>
        <!-- /#page-wrapper -->

    </div>	
    <!-- /#wrapper -->
<script src="//code.jquery.com/jquery.js"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<?php if (!empty($this->jsfiles)): ?>
	<?php foreach($this->jsfiles as $jsfile):?>
		<script type="text/javascript" language="javascript" src="<?= base_url() ?>assets/js/<?=$jsfile?>.js"></script>
	<?php endforeach ?>
<?php endif; ?>
</body>

</html>
