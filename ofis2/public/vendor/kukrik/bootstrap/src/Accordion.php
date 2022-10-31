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
use QCubed\Control\DataRepeater;
use QCubed\Control\FormBase;
use QCubed\Exception\Caller;
use QCubed\Html;
use QCubed\Type;
use QCubed as Q;

/**
 * Accordion class
 * A wrapper class for objects that will be displayed using the RenderFormGroup method, and that will be drawn using
 * the "form-inline" class for special styling.
 *
 * You should set the PreferredRenderMethod attribute for each of the objects you add.
 *
 * Also, for objects that will be drawn with labels, use the "sr-only" class to hide the labels so that they are
 * available for screen readers.
 *
 * @property-write string $PanelStyle
 */


class Accordion extends DataRepeater
{
    const RENDER_HEADER = 'header';
    const RENDER_BODY = 'body';
    const RENDER_FOOTER = 'footer';

    protected $strCssClass = Bootstrap::PANEL_GROUP;
    protected $intCurrentOpenItem = 0;
    protected $drawingCallback;
    protected $strPanelStyle = Bootstrap::PANEL_DEFAULT;

    /**
     * Accordion constructor.
     * @param ControlBase|FormBase $objParent
     * @param null $strControlId
     */
    public function __construct($objParent, $strControlId = null)
    {
        parent::__construct($objParent, $strControlId);

        $this->strTemplate = __DIR__ . '/accordion.tpl.php';
        $this->setHtmlAttribute("role", "tablist");
        $this->setHtmlAttribute("aria-multiselectable", "true");
        Bootstrap::loadJS($this);
    }

    /**
     * Set the callback that will be used to draw the various parts of the accordion. Callback should take the following
     * parameters:
     *  $objAccordion the accordion object
     *  $strPart, what part of the accordion item is being drawn. See below.
     *  $objItem the item object from the data source
     *  $intItemIndex the index of the item being drawn
     * @param $callable
     */
    public function setDrawingCallback($callable)
    {
        $this->drawingCallback = $callable;
    }

    /**
     * Callback from the standard template to render the header html. Calls the callback. The call callback should
     * call the RenderToggleHelper to render the toggling portion of the header.
     * @param $objItem
     */
    protected function renderHeading($objItem)
    {
        if ($this->drawingCallback) {
            call_user_func_array($this->drawingCallback, [$this, self::RENDER_HEADER, $objItem, $this->intCurrentItemIndex]);
        }
    }

    /**
     * Renders the body of an accordion item. Calls the callback to do so. You have some options here:
     * 	Draw just text. You should surround your text with <div class="panel-body"></div>
     *  Draw an item list. You should output a <ul class="list-group"> list (no panel-body needed). See the Bootstrap doc.
     * @param $objItem
     */
    protected function renderBody($objItem)
    {
        if ($this->drawingCallback) {
            call_user_func_array($this->drawingCallback, [$this, self::RENDER_BODY, $objItem, $this->intCurrentItemIndex]);
        }
    }

    /**
     * Renders the footer of an accordion item. Calls the callback to do so.
     * You should surround the content with a <div class="panel-footer"></div>.
     * If you don't want a footer, do nothing in response to the callback call.
     * @param $objItem
     */
    protected function renderFooter($objItem)
    {
        if ($this->drawingCallback) {
            call_user_func_array($this->drawingCallback, [$this, self::RENDER_FOOTER, $objItem, $this->intCurrentItemIndex]);
        }
    }

    public function sleep()
    {
        $this->drawingCallback = Q\Project\Control\ControlBase::sleepHelper($this->drawingCallback);
        parent::sleep();
    }

    /**
     * The object has been unserialized, so fix up pointers to embedded objects.
     * @param FormBase $objForm
     */
    public function wakeup(FormBase $objForm)
    {
        parent::wakeup($objForm);
        $this->drawingCallback = Q\Project\Control\ControlBase::wakeupHelper($objForm, $this->drawingCallback);
    }

    /**
     * @return mixed
     */
    protected function getState()
    {
        $state = parent::getState();
        if ($this->intCurrentOpenItem !== null) {
            $state["sel"] = $this->intCurrentOpenItem;
        }
        return $state;
    }

    /**
     * @param mixed $state
     */
    protected function putState($state)
    {
        if (isset($state["sel"])) {
            $this->intCurrentOpenItem = $state["sel"];
        }
        parent::putState($state);
    }


    /**
     * Renders the given html with an anchor wrapper that will make it toggle the currently drawn item. This should be called
     * from your drawing callback when drawing the heading. This could span the entire heading, or just a portion.
     *
     * @param string $strHtml
     * @param bool $blnRenderOutput
     * @return string
     */
    public function renderToggleHelper($strHtml, $blnRenderOutput = true)
    {
        if ($this->intCurrentItemIndex == $this->intCurrentOpenItem) {
            $strClass = '';
            $strExpanded = 'true';
        } else {
            $strClass = 'collapsed';
            $strExpanded = 'false';
        }
        $strCollapseId = $this->strControlId . '_collapse_' . $this->intCurrentItemIndex;

        $strOut = Html::renderTag('a',
                ['class'=>$strClass,
                'data-toggle'=>'collapse',
                'data-parent'=>'#' . $this->strControlId,
                'href'=>'#' . $strCollapseId,
                'aria-expanded'=>$strExpanded,
                'aria-controls'=>$strCollapseId],
                $strHtml, false, true);

        if ($blnRenderOutput) {
            echo $strOut;
            return '';
        } else {
            return $strOut;
        }
    }

    /**
     * @param string $strName
     * @param string $mixValue
     * @throws Caller
     * @return void
     */
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case 'PanelStyle':
                $this->strPanelStyle = Type::cast($mixValue, Type::STRING);
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
