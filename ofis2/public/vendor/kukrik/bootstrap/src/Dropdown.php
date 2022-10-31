<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Action\ActionBase;
use QCubed\Action\ActionParams;
use QCubed\Control\ControlBase;
use QCubed\Control\FormBase;
use QCubed\Control\HList;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Html;
use QCubed\Project\Application;
use QCubed\Type;
use QCubed\Js;

/**
 * Class Dropdown
 *
 * Implements a standalone dropdown button. This can be styled as a typical bootstrap button, with the dropdown list
 * inside the button, or without a button surrounding the list, which makes it look more like a typical menu list.
 *
 * @package QCubed\Bootstrap
 *
 * @property string  	$StyleClass		The button style. i.e. Bootstrap::ButtonPrimary
 * @property string  	$SizeClass 		The button size class. i.e. Bootstrap::ButtonSmall
 * @property bool  		$AsButton 		Whether to show it as a button, or a just a menu.
 * @property bool  		$Split 			Whether to split the button into a button and a menu.
 * @property bool  		$Up 			Whether to pop up the menu above or below the button.
 * @property bool  		$Text 			The text to appear on the button. Synonym of Name.
 */
class Dropdown extends HList {
	/** @var bool Whether to show it as a button tag or anchor tag */
	protected $blnAsButton = false;
	protected $blnSplit = false;
	protected $blnUp = false;
	protected $strButtonStyle = Bootstrap::BUTTON_DEFAULT;
	protected $strButtonSize = '';

	/**
	 * Dropdown constructor.
     * @param ControlBase|FormBase $objParentObject
     * @param null|string $strControlId
     */
	public function __construct($objParentObject, $strControlId = null)
	{
		parent::__construct($objParentObject, $strControlId);

		// utilize the wrapper to group the components of the button
		$this->blnUseWrapper = true;
		$this->addWrapperCssClass("dropdown"); // default to menu type of drowdown
	}

	/**
	 * Returns the html for the control.
	 * @return string
	 * @throws Caller
	 */
	public function getControlHtml() {
		$strHtml = Html::renderString($this->Name);
		if (!$this->blnAsButton) {
			$strHtml .= ' <span class="caret"></span>';
			$strHtml = $this->renderTag("a", ["href"=>"#", "data-toggle"=>"dropdown", "aria-haspopup"=>"true", "aria-expanded"=>"false"], null, $strHtml);
		} else {
			if (!$this->blnSplit) {
				$strHtml .= ' <span class="caret"></span>';
				$strHtml = $this->renderTag("button", ["data-toggle"=>"dropdown", "aria-haspopup"=>"true", "aria-expanded"=>"false"], null, $strHtml);
			} else {
				$strHtml = $this->renderTag("button", null, null, $strHtml);
				$strClass = "btn dropdown-toggle " . $this->strButtonSize . " " . $this->strButtonStyle;
				$strHtml .= Html::renderTag("button", ["class" => $strClass, "data-toggle"=>"dropdown", "aria-haspopup"=>"true", "aria-expanded"=>"false"]);
			}
		}
		if ($this->hasDataBinder()) {
			$this->callDataBinder();
		}
		if ($this->getItemCount()) {
			$strListHtml = '';
			foreach ($this->getAllItems() as $objItem) {
				$strListHtml .= $this->getItemHtml($objItem);
			}

			$strHtml .= Html::renderTag("ul", ["id"=>$this->ControlId . "_list", "class"=>"dropdown-menu", "aria-labelledby" => $this->ControlId], $strListHtml);
		}
		if ($this->hasDataBinder()) {
			$this->removeAllItems();
		}

		return $strHtml;
	}

	/**
	 * Alias to add a dropdown menu item
	 * @param DropdownItem $objMenuItem
	 */
	public function addMenuItem($objMenuItem) {
		parent::addItem($objMenuItem);
	}

	/**
	 * Return the text html of the item.
	 *
	 * @param DropdownItem $objItem
	 * @return string
	 */
	protected function getItemText($objItem) {
		return $objItem->getItemText();	// redirect to subclasses of item
	}

	/**
	 * Return the attributes for the sub tag that wraps the item tags
     *
     * @param mixed $objItem
     * @return mixed
     */
	public function getSubTagAttributes($objItem) {
		return $objItem->getSubTagAttributes();
	}

	/**
	 * Set the button style class.
	 * @param $strStyleClass
	 * @throws Caller
	 * @throws InvalidCast
	 */
	public function setStyleClass($strStyleClass) {
		$this->removeCssClass($this->strButtonStyle);
		$this->strButtonStyle = Type::cast($strStyleClass, Type::STRING);
		$this->addCssClass($this->strButtonStyle);
	}

	/**
	 * Set the button size class.
	 *
	 * @param $strSizeClass
	 * @throws Caller
	 * @throws InvalidCast
	 */
	public function setSizeClass($strSizeClass) {
		$this->removeCssClass($this->strButtonStyle);
		$this->strButtonSize = Type::cast($strSizeClass, Type::STRING);
		$this->addCssClass($this->strButtonSize);
	}

	/**
	 * Returns the javascript associated with the button.
	 *
	 * @throws Caller
	 */
	protected function makeJqWidget() {
		// Trigger the dropdown select event on the main control
		Application::executeSelectorFunction('#' . $this->ControlId . "_list", 'on', 'click', 'li',
			new Js\Closure("\njQuery('#$this->ControlId').trigger ('bsdropdownselect', {id:this.id, value:\$j(this).data('value')});\n"), Application::PRIORITY_HIGH);
	}

	/**
	 * An override to make sure the public value gets decrypted before being sent to the action function.
	 *
	 * @param ActionParams $params
	 * @return void
	 */
	protected function processActionParameters(ActionParams $params) {
		parent::processActionParameters($params);
		if ($this->blnEncryptValues) {
		    $actionParam = $params->ActionParameter;

            $actionParam['value'] = $this->decryptValue($actionParam['value']); // Decrypt the value if needed.
            $params->ActionParameter = $actionParam;
		}
	}

	/**
	 * Magic Get method
	 *
	 * @param string $strName
	 * @return bool|mixed|null|string
	 * @throws Caller
	 * @throws Caller
	 */
	public function __get($strName) {
		switch ($strName) {
			// APPEARANCE
			case "StyleClass": return $this->strButtonStyle;
			case "SizeClass": return $this->strButtonSize;
			case "AsButton": return $this->blnAsButton;
			case "Split": return $this->blnSplit;
			case "Up": return $this->blnUp;
			case "Text": return $this->strName;
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
	 * Magic setter.
	 *
	 * @param string $strName
	 * @param string $mixValue
	 * @throws Caller
	 * @throws InvalidCast
	 */
	public function __set($strName, $mixValue) {
		switch ($strName) {
			case "StyleClass":	// One of Bootstrap::ButtonDefault, ButtonPrimary, ButtonSuccess, ButtonInfo, ButtonWarning, ButtonDanger
				$this->setStyleClass($mixValue);
				break;

			case "SizeClass": // One of Bootstrap::ButtonLarge, ButtonMedium, ButtonSmall, ButtonExtraSmall
				$this->setSizeClass($mixValue);
				break;

			case "AsButton":
				$this->blnAsButton = Type::cast($mixValue, Type::BOOLEAN);
				if ($this->blnAsButton) {
					$this->addCssClass("btn");
					$this->addCssClass($this->strButtonStyle);
					if ($this->strButtonSize) {
						$this->addCssClass($this->strButtonSize);
					}
					if (!$this->blnSplit) {
						$this->addCssClass("dropdown-toggle");
					}
					$this->removeWrapperCssClass("dropdown");
					$this->addWrapperCssClass("btn-group");
				} else {
					$this->removeCssClass("btn");
					$this->removeCssClassesByPrefix("btn-");
					$this->addWrapperCssClass("dropdown");
					$this->removeWrapperCssClass("btn-group");
				}
				break;

			case "Split":
				$this->blnSplit = Type::cast($mixValue, Type::BOOLEAN);
				if (!$this->blnSplit) {
					$this->addCssClass("dropdown-toggle");
				} else {
					$this->removeCssClass("dropdown-toggle");
				}

				break;

			case "Up":
				$this->blnUp = Type::cast($mixValue, Type::BOOLEAN);
				if ($this->blnUp) {
					$this->addWrapperCssClass("dropup");
				} else {
					$this->removeWrapperCssClass("dropup");
				}
				break;

			case "Text":
				// overload Name as Text too.
				parent::__set("Name", $mixValue);
				break;


			default:
				try {
					parent::__set($strName, $mixValue);
				} catch (InvalidCast $objExc) {
					$objExc->incrementOffset();
					throw $objExc;
				}
				break;
		}

	}
}

