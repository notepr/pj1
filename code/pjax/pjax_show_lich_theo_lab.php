<?php if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true'): ?>
	<?php require_once "../lich_hoc/show_lich_theo_lab.php"?>
	<script src="../script/script_show_lich_theo_lab.js?=<?php echo rand() ?>"></script>

<?php else: ?>
	<?php require_once "../view/header.php"?>
	<hr>
	<div id="middle" style="display: flex; justify-content: space-between; width: 100%; height: auto;">
	    <?php require_once "../view/menu.php"?>
	    <div id="content" style="width: 75%; height: 100%;">
	    	<?php require_once "../lich_hoc/show_lich_theo_lab.php"?>
		</div>
	</div>
	<script src="../script/script_show_lich_theo_lab.js"></script>
	<hr>
	<?php require_once "../view/footer.php"?>

<?php endif?>
