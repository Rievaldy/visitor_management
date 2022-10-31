<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\ControlBase;
use QCubed\Control\FormBase;
use QCubed\Control\Panel;
use QCubed\Exception\Caller;
use QCubed\Html;
use QCubed\Js;
use QCubed\Project\Application;
use QCubed\Type;

/**
 * Class Alert
 *
 * Implements the Bootstrap "Alert" functionality. This can be a static block of text, or can alternately have a close
 * button that automatically hides the alert.
 *
 * Per Bootstraps documentation, you MUST specify an alert type class. Do this by using AddCssClass, or the CssClass
 * Attribute with a plus in front of the class. For example:
 * 	$objAlert->CssClass = '+' . Bootstrap::AlertSuccess;
 *
 * Use Display or Visible to show or hide the alert as needed. Or, set the
 * Dismissable attribute.
 *
 * Since its a \QCubed\Control\Panel, you can put text, template or child controls in it.
 *
 * By default, alerts will fade on close. Remove the fade class if you want to turn this off.
 *
 * Call Close() to close the alert manually.
 *
 */
class Alert extends Panel {
	protected $strCssClass = 'alert fade in';

	protected $blnDismissable = false;

    /**
     * Alert constructor.
     * @param ControlBase|FormBase $objParent
     * @param null $strControlId
     */
	public function __construct ($objParent, $strControlId = null) {
		parent::__construct ($objParent, $strControlId);

		$this->setHtmlAttribute("role", "alert");
		Bootstrap::loadJS($this);
	}

    /**
     * Returns the inner html of the tag.
     *
     * @return string
     */
	protected function getInnerHtml() {
		$strText = parent::getInnerHtml();

		if ($this->blnDismissable) {
			$strText = Html::renderTag('button',
				['type'=>'button',
				'class'=>'close',
				'data-dismiss'=>'alert',
				'aria-label'=>"Close",
				],
				'<span aria-hidden="true">&times;</span>', false, true)
			. $strText;
		}
		return $strText;
	}

    /**
     * Attach the javascript to the control
     */
	protected function makeJqWidget() {
	    parent::makeJqWidget();
		if ($this->blnDismissable) {
			Application::executeControlCommand($this->ControlId, 'on', 'closed.bs.alert',
				new Js\Closure("qcubed.recordControlModification ('{$this->ControlId}', '_Visible', false)"), Application::PRIORITY_HIGH);
		}
	}

	/**
	 * Closes the alert using the Bootstrap javascript mechanism to close it. Removes the alert from the DOM.
	 * Bootstrap has no mechanism for showing it again, so you will need
	 * to redraw the control to show it.
	 */
	public function close() {
		$this->blnVisible = false;
		Application::executeControlCommand($this->ControlId, 'alert', 'close');
	}

    /**
     * @param string $strName
     * @return mixed
     * @throws Caller
     */
	public function __get($strName) {
		switch ($strName) {
			case "Dismissable":
			case "HasCloseButton": // QCubed synonym
				return $this->blnDismissable;

			default:
				try {
					return parent::__get($strName);
				} catch (Caller $objExc) {
					$objExc->incrementOffset();
					throw $objExc;
				}
		}
	}

    /**
     * @param string $strName
     * @param string $mixValue
     * @throws Caller
     * @return void
     */
	public function __set($strName, $mixValue) {
		switch ($strName) {
			case 'Dismissable':
			case "HasCloseButton": // QCubed synonym
				$blnDismissable = Type::cast($mixValue, Type::BOOLEAN);
				if ($blnDismissable != $this->blnDismissable) {
					$this->blnDismissable = $blnDismissable;
					$this->blnModified = true;
					if ($blnDismissable) {
						$this->addCssClass(Bootstrap::ALERT_DISMISSABLE);
						Bootstrap::loadJS($this);
					} else {
						$this->removeCssClass(Bootstrap::ALERT_DISMISSABLE);
					}
				}
				break;

			case '_Visible':	// Private attribute to record the visible state of the alert
				$this->blnVisible = $mixValue;
				break;


			default:
				try {
					parent::__set($strName, $mixValue);
				} catch (Caller $objExc) {
					$objExc->incrementOffset();
					throw $objExc;
				}
				break;
		}
	}

}