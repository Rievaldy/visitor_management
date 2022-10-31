<?php

/**
 * The ClockPicker override file. This file gets installed into project/includes/plugins duing the initial installation
 * of the plugin. After that, it is not touched. Feel free to modify this file as needed.
 */

namespace QCubed\Plugin;

use QCubed as Q;
use QCubed\Exception\Caller;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase;
use QCubed\Project\Application;


/**
 * ClockPickerBase constructor
 *
 * @param ControlBase|FormBase|null $objParentObject
 * @param null|string $strControlId
 */

class ClockPicker extends ClockPickerBase
{
	public function  __construct($objParentObject, $strControlId = null) {
		parent::__construct($objParentObject, $strControlId);
		$this->registerFiles();
		$this->setHtmlAttribute('autocomplete', 'off');
	}

	/**
	 * @throws Caller
	 */

	protected function registerFiles() {
		$this->AddJavascriptFile(QCUBED_CLOCKPICKER_ASSETS_URL . "/js/bootstrap-clockpicker.min.js");
		$this->addCssFile(QCUBED_CLOCKPICKER_ASSETS_URL . "/css/bootstrap-clockpicker.min.css");
		$this->AddCssFile(QCUBED_BOOTSTRAP_CSS); // make sure they know
		$this->AddCssFile(QCUBED_FONT_AWESOME_CSS); // make sure they know
	}

}