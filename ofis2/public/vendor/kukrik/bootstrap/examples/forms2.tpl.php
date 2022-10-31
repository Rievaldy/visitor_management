<?php     require(QCUBED_CONFIG_DIR . '/header.inc.php'); ?>
    <link href="<?= QCUBED_BOOTSTRAP_CSS ?>" rel="stylesheet">

<?php $this->renderBegin(); ?>


	<div class="instructions">
		<h1 class="instruction_title">QBootstrap: Form Examples</h1>

		<p>
			These examples show how to display form objects the Bootstrap way. It includes standard examples,
			but also some examples using some minor custom css modifications to allow more complex form layouts
			than the default Bootstrap provides.
		</p>
	</div>

	<ul class="nav nav-pills">
		<li role="presentation"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms1' ?>">Default</a></li>
		<li role="presentation" class="active"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms2' ?>">Inline</a></li>
		<li role="presentation"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms3' ?>">Horizontal</a></li>
		<li role="presentation"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms4' ?>">Horizontal 2</a></li>
		<li role="presentation"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms5' ?>">Horizontal 3</a></li>
	</ul>

	<h2>Inline Bootstrap Form</h2>
	<div class="form-inline">
		<div>
			<?php $this->firstName->RenderFormGroup(true, ['Width' => '200']); ?>
			<?php $this->lastName->RenderFormGroup(true, ['Width' => '200']); ?>
		</div>
		<?php $this->street->RenderFormGroup(true, ['Width' => '600']); ?>
		<div>
			<?php $this->city->RenderFormGroup(true, ['Width' => '400']); ?>
			<?php $this->state->RenderFormGroup(true, ['Width' => '100']); ?>
			<?php $this->zip->RenderFormGroup(true, ['Width' => '300']); ?>

		</div>
		<?php $this->button->RenderFormGroup(); ?>

	</div>

<?php $this->renderEnd(); ?>
<?php     require(QCUBED_CONFIG_DIR . '/footer.inc.php'); ?>