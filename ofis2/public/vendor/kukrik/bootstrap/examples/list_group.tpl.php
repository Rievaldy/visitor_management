<?php     require(QCUBED_CONFIG_DIR . '/header.inc.php'); ?>
    <link href="<?= QCUBED_BOOTSTRAP_CSS ?>" rel="stylesheet">
    <link href="<?= QCUBED_BOOTSTRAP_ASSETS_URL ?>/css/qbootstrap.css" rel="stylesheet">

<?php $this->renderBegin(); ?>

	<div class="instructions">
		<h1 class="instruction_title">Bootstrap ListGroup and Pager</h1>

		<p>
			The <strong>ListGroup</strong> subclasses a <strong>\QCubed\Control\DataRepeater</strong> to implement a Bootstrap list group that you can select items from.
			The selection will be remembered and restored if you set <strong>SaveState</strong> to true.
		</p>
		<p>
			To use it, you must implement a data binder to recall the data, and also an <strong>ItemParamsCallback</strong> to interpret
			each item and draw it.
		</p>
		<p>
			This code also demonstrates a Bootstrap <strong>Pager</strong> control implementation. The <strong>Pager</strong> is optional when using the list group.
		</p>


	</div>
	<div class="content">
		<div class="well">
			<div class="row">
				<div class="col-sm-4">
					<div class="center">
						<?php $this->pager->Render(); ?>
					</div>
					<?php $this->lg->Render(); ?>
				</div>
				<div class="col-sm-8">
					<?php $this->lblClicked->RenderWithName(); ?>
				</div>
			</div>
		</div>
	</div>




<?php $this->renderEnd(); ?>
<?php     require(QCUBED_CONFIG_DIR . '/footer.inc.php'); ?>