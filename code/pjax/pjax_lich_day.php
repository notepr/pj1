<?php require_once "../../check_login.php" ?>
<?php if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true'): ?>
	<?php require_once "../lich_hoc/input_lich_day.php"?>
	<script src="../script/script_lich_day_1.js?=<?php echo rand() ?>"></script>
	<script src="../script/script_lich_day_2.js?=<?php echo rand() ?>"></script>

<?php else: ?>
	<?php require_once "../view/header.php"?>
	<hr>
	<div id="middle" style="display: flex; justify-content: space-between; width: 100%; height: auto;">
	    <?php require_once "../view/menu.php"?>
	    <div id="content" style="width: 75%; height: 100%;">
	    	<?php require_once "../lich_hoc/input_lich_day.php"?>
		</div>
	</div>
	<script src="../script/script_lich_day_1.js"></script>
	<script src="../script/script_lich_day_2.js"></script>
	<hr>
	<?php require_once "../view/footer.php"?>

<?php endif?>
