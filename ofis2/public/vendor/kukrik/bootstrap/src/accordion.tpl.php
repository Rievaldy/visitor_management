<?php
    /**
     * This is a generic repeater template for an accordion. It calls back into the accordion object to draw the various
     * parts of the accordion, allowing you to subclass the accordion and draw the parts. However, you can always
     * use your own template if this does not suit your needs.
     */
?>
	<div class="panel <?= $this->strPanelStyle?>">
		<div class="panel-heading" role="tab" id="<?= $this->strControlId ?>_heading_<?= $this->intCurrentItemIndex ?>">
			<?php $this->renderHeading($_ITEM); ?>
		</div>
		<div id="<?= $this->strControlId ?>_collapse_<?= $this->intCurrentItemIndex ?>" class="panel-collapse collapse <?= $this->intCurrentItemIndex == $this->intCurrentOpenItem ? 'in' : '' ?>" role="tabpanel" aria-labelledby="<?= $this->strControlId ?>_heading_<?= $this->intCurrentItemIndex ?>">
			<div class="panel-body">
				<?php $this->renderBody($_ITEM); ?>
			</div>
			<?php $this->renderFooter($_ITEM); ?>
		</div>
	</div>
