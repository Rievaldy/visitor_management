<?php     require(QCUBED_CONFIG_DIR . '/header.inc.php'); ?>
    <link href="<?= QCUBED_BOOTSTRAP_CSS ?>" rel="stylesheet">
    <link href="<?= QCUBED_BOOTSTRAP_ASSETS_URL ?>/css/qbootstrap.css" rel="stylesheet">

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
		<li role="presentation"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms2' ?>">Inline</a></li>
		<li role="presentation"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms3' ?>">Horizontal</a></li>
		<li role="presentation"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms4' ?>">Horizontal 2</a></li>
		<li role="presentation" class="active"><a href="<?= \QCubed\Project\Application::instance()->context()->scriptName() . '?formName=forms5' ?>">Horizontal 3</a></li>
	</ul>

	<h2>Custom Mixed Horizontal and Inline Bootstrap Form with Columns</h2>
	<div class="container qform-horizontal">
		<div class="row">
			<label class="col-sm-2 control-label">Name</label>
			<?php $this->firstName->RenderFormGroup(true, ['WrapperCssClass' => '+ col-sm-5', 'LabelCssClass' => 'sr-only',
				'HorizontalClass' => 'col-sm-12', 'Placeholder'=>t('First Name')]); ?>
			<?php $this->lastName->RenderFormGroup(true, ['WrapperCssClass' => '+ col-sm-5', 'LabelCssClass' => 'sr-only',
				'HorizontalClass' => 'col-sm-12','Placeholder'=>t('Last Name')]); ?>

		</div>
		<div class="row">
			<label class="col-sm-2 control-label">Address</label>
			<?php $this->street->RenderFormGroup(true, ['WrapperCssClass' => '+ col-sm-10', 'LabelCssClass' => 'sr-only',
				'HorizontalClass' => 'col-sm-12', 'Placeholder'=>t('Street')]); ?>

		</div>
		<div class="row">
			<?php $this->city->RenderFormGroup(true, ['WrapperCssClass'=>'+ col-sm-5 col-sm-offset-2', 'LabelCssClass'=>'sr-only',
				'HorizontalClass'=>'col-sm-12', 'Placeholder'=>'City']); ?>
			<?php $this->state->RenderFormGroup(true, ['WrapperCssClass'=>'+ col-sm-2', 'LabelCssClass'=>'sr-only',
				'HorizontalClass'=>'col-sm-12', 'Placeholder'=>'State']); ?>
			<?php $this->zip->RenderFormGroup(true, ['WrapperCssClass'=>'+ col-sm-3', 'LabelCssClass'=>'sr-only',
				'HorizontalClass'=>'col-sm-12', 'Placeholder'=>'Zip']); ?>

		</div>

		<div class="row">
			<?php $this->button->RenderFormGroup(true, ['HorizontalClass' => 'col-sm-10 col-sm-offset-2']); ?>
		</div>

	</div>

<?php $this->renderEnd(); ?>
<?php     require(QCUBED_CONFIG_DIR . '/footer.inc.php'); ?>