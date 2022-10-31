<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\FormBase;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Project\Application;
use QCubed\Js;
use QCubed\Type;
use QCubed as Q;

/**
 * Class Navbar
 *
 * A control that implements a Bootstrap Navbar
 * The "HeaderHtml" attribute will be used as the header text, and the child controls will be used as the
 * "collapse" area. To render an image in the header, set the "HeaderHtml" attribute to the image html.
 *
 * Usage: Create a Navbar object, and add a NavbarList for drop down menus, adding a NavbarItem to the list for each
 *          item in the list. You can also add NavbarItems directly to the Navbar object for a link in the navbar.
 *
 * @property string $ContainerClass
 * @property string $HeaderText
 * @property string $HeaderAnchor
 * @property string $Value
 * @property string $SelectedId
 * @property string $StyleClass
 *
 * @package QCubed\Bootstrap
 */
class Navbar extends Q\Project\Control\ControlBase
{
    protected $strHeaderAnchor;
    protected $strHeaderText;
    protected $strCssClass = 'navbar navbar-default';


    protected $strStyleClass = 'navbar-default';
    protected $strContainerClass = Bootstrap::CONTAINER_FLUID;
    protected $strSelectedId;

    /**
     * Navbar constructor.
     * @param Q\Control\ControlBase|FormBase $objParent
     * @param null $strControlId
     */
    public function __construct($objParent, $strControlId = null)
    {
        parent::__construct($objParent, $strControlId);

        $this->addCssFile(QCUBED_BOOTSTRAP_CSS);
        Bootstrap::loadJS($this);
    }

    public function validate()
    {
        return true;
    }

    public function parsePostData()
    {
    }

    /**
     * @return string
     */
    protected function getControlHtml()
    {
        $strChildControlHtml = $this->renderChildren(false);

        $strHeaderText = '';
        if ($this->strHeaderText) {
            $strAnchor = 'href="#"';
            if ($this->strHeaderAnchor) {
                $strAnchor = 'href="' . $this->strHeaderAnchor . '"';
            }
            $strHeaderText = '<a class="navbar-brand" ' . $strAnchor . '>' . $this->strHeaderText . '</a>';
        }

        $strHtml = <<<TMPL
<div class="$this->strContainerClass">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#{$this->strControlId}_collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		 </button>

		$strHeaderText

	</div>
	<div class="collapse navbar-collapse" id="{$this->strControlId}_collapse">
		$strChildControlHtml
	</div>
</div>
TMPL;

        return $this->renderTag('nav', ['role' => 'navigation'], null, $strHtml);
    }

    /**
     */
    protected function makeJqWidget()
    {
        parent::makeJqWidget();
        Application::executeControlCommand(
            $this->ControlId, 'on', 'click', 'li',
            new Js\Closure("qcubed.recordControlModification ('{$this->ControlId}', 'SelectedId', this.id); jQuery(this).trigger ('bsmenubarselect', {id: this.id, value: jQuery(this).data('value')})"),
            Application::PRIORITY_HIGH);
    }


    /**
     * @param string $strText
     * @return mixed|string
     * @throws Caller
     */
    public function __get($strText)
    {
        switch ($strText) {
            case "ContainerClass":
                return $this->strContainerClass;
            case "HeaderText":
                return $this->strHeaderText;
            case "HeaderAnchor":
                return $this->strHeaderAnchor;
            case "Value":
            case "SelectedId":
                return $this->strSelectedId;
            case "StyleClass":
                return $this->strStyleClass;

            default:
                try {
                    return parent::__get($strText);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }

    /**
     * @param $strText
     * @param $mixValue
     * @throws Caller
     * @throws InvalidCast
     * @return void
     */
    public function __set($strText, $mixValue)
    {
        switch ($strText) {
            case "ContainerClass":
                try {
                    // Bootstrap::ContainerFluid or Bootstrap::Container
                    $this->strContainerClass = Type::cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case "HeaderText":
                try {
                    $this->strHeaderText = Type::cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case "HeaderAnchor":
                try {
                    $this->strHeaderAnchor = Type::cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case "Value":
            case "SelectedId":
                try {
                    $this->strSelectedId = Type::cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case "StyleClass":
                try {
                    $mixValue = Type::cast($mixValue, Type::STRING);
                    $this->removeCssClass($this->strStyleClass);
                    $this->addCssClass($mixValue);
                    $this->strStyleClass = $mixValue;
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }


            default:
                try {
                    parent::__set($strText, $mixValue);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;
        }
    }
}



/*
 *
 * Custom Navbar Creation Code for BS v3
 *
 *
 *
 @bgDefault      : #9b59b6;
@bgHighlight    : #8e44ad;
@colDefault     : #ecf0f1;
@colHighlight   : #ecdbff;
.navbar-XXX {
    background-color: @bgDefault;
    border-color: @bgHighlight;
    .navbar-brand {
        color: @colDefault;
        &:hover, &:focus {
            color: @colHighlight; }}
    .navbar-text {
        color: @colDefault; }
    .navbar-nav {
        > li {
            > a {
                color: @colDefault;
                &:hover,  &:focus {
                    color: @colHighlight; }}}
        > .active {
            > a, > a:hover, > a:focus {
                color: @colHighlight;
                background-color: @bgHighlight; }}
        > .open {
            > a, > a:hover, > a:focus {
                color: @colHighlight;
                background-color: @bgHighlight; }}}
    .navbar-toggle {
        border-color: @bgHighlight;
        &:hover, &:focus {
            background-color: @bgHighlight; }
        .icon-bar {
            background-color: @colDefault; }}
    .navbar-collapse,
    .navbar-form {
        border-color: @colDefault; }
    .navbar-link {
        color: @colDefault;
        &:hover {
            color: @colHighlight; }}}
@media (max-width: 767px) {
    .navbar-default .navbar-nav .open .dropdown-menu {
        > li > a {
            color: @colDefault;
            &:hover, &:focus {
                color: @colHighlight; }}
        > .active {
            > a, > a:hover, > a:focus, {
                color: @colHighlight;
                background-color: @bgHighlight; }}}
}
 */
