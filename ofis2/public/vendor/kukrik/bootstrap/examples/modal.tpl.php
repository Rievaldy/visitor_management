<?php     require(QCUBED_CONFIG_DIR . '/header.inc.php'); ?>
    <link href="<?= QCUBED_BOOTSTRAP_CSS ?>" rel="stylesheet">
    <link href="<?= QCUBED_BOOTSTRAP_ASSETS_URL ?>/css/qbootstrap.css" rel="stylesheet">

<?php $this->renderBegin(); ?>

	<div class="instructions">
		<h1 class="instruction_title">Bootstrap\Modal: A class to implement Bootstrap Modal dialogs.</h1>

		<p>
			The Modal can implement modals as documented in the Bootstrap Javascript documentation.
		</p>
		<p>
			Its interface is similar to the \QCubed\Project\Jqui\Dialog interface, and can be mostly a drop-in replacement for it. It does
			have some Bootstrap specific options that are in addition to the standard interface.
		</p>

	</div>

	<h2>
		Basic implementation
	</h2>
<?php $this->btn1->Render(); ?>
<?php $this->btn2->Render(); ?>

<?php
 /*
  *  You do not need to render a modal. That will be handled automatically.
  */
?>

<?php $this->renderEnd(); ?>
<?php     require(QCUBED_CONFIG_DIR . '/footer.inc.php'); ?>