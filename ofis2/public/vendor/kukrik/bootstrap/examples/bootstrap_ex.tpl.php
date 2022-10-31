<?php     require(QCUBED_CONFIG_DIR . '/header.inc.php'); ?>
    <link href="<?= QCUBED_BOOTSTRAP_CSS ?>" rel="stylesheet">

<?php $this->renderBegin(); ?>

	<div class="instructions">
		<h1 class="instruction_title">Bootstrap: Support  and objects for Twitter Bootstrap</h1>

		<b>QCubed\Bootstrap</b> is a collection of classes that integrate into QCubed to do two things:
		<ul>
			<li>Make all QCubed objects capable of being styled with bootstrap styles, and</li>
			<li>Provide specific <em>QCubed\Controls</em> based on Bootstrap widgets.</li>
		</ul>
		<p>
			Be sure to read the ReadMe file for directions on how to install and set up the plugin.
			The setup process is a bit more complex than a standard plugin installation, but
			is still quite easy.
		</p>

	</div>

	<h2>
		Navbar
	</h2>
	<?php $this->navBar->Render(); ?>
	<h2>
		Carousel
	</h2>
	<?php $this->carousel->Render(); ?>
	<h2>
		Accordion
	</h2>
<?php $this->accordion->Render(); ?>
	<h2>
		Button Groups
	</h2>
<?php $this->lstRadio1->Render(); ?>
<?php $this->lstRadio2->Render(); ?>
	<h2>
		Dropdowns
	</h2>

<?php $this->lstPlain->Render(); ?>


<?php $this->renderEnd(); ?>
<?php     require(QCUBED_CONFIG_DIR . '/footer.inc.php'); ?>