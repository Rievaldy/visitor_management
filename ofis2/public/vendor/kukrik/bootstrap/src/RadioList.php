<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\ListControl;
use QCubed\Control\RadioButtonList;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Html;
use QCubed\TagStyler;
use QCubed\Type;

/**
 * Class RadioList
 *
 * Bootstrap specific drawing of a \QCubed\Control\RadioButtonList
 *
 * Modes:
 * 	ButtonModeNone	Display as standard radio buttons using table styling if specified
 *  ButtonModeJq	Display as separate radio buttons styled with bootstrap styling
 *  ButtonModeSet	Display as a button group
 *  ButtonModeList	Display as standard radio buttons with no structure
 *
 * @property-write string ButtonStyle Bootstrap::ButtonPrimary, ButtonSuccess, etc.
 * @package QCubed\Bootstrap
 */
class RadioList extends RadioButtonList
{
    protected $blnWrapLabel = true;
    protected $strButtonGroupClass = "radio";
    protected $strButtonStyle = Bootstrap::BUTTON_DEFAULT;

    /**
     * Used by drawing routines to render the attributes associated with this control.
     *
     * @param null|array $attributeOverrides
     * @param null|array $styleOverrides
     * @return string
     */
    public function renderHtmlAttributes($attributeOverrides = null, $styleOverrides = null)
    {
        if ($this->intButtonMode == RadioButtonList::BUTTON_MODE_SET) {
            $attributeOverrides["data-toggle"] = "buttons";
            $attributeOverrides["class"] = $this->CssClass;
            Html::addClass($attributeOverrides["class"], "btn-group");
        }
        return parent::renderHtmlAttributes($attributeOverrides, $styleOverrides);
    }


    /**
     * Overrides the radio list get end script to prevent the default JQueryUi functionality.
     * @return string
     */
    public function getEndScript()
    {
        $strScript = ListControl::getEndScript();    // bypass the \QCubed\Control\RadioButtonList end script
        return $strScript;
    }

    /**
     * Renders the radio list as a buttonset, rendering just as a list of radio buttons and allowing css or javascript
     * to format the rest.
     * @return string
     */
    public function renderButtonSet()
    {
        $count = $this->ItemCount;
        $strToReturn = '';
        for ($intIndex = 0; $intIndex < $count; $intIndex++) {
            $strToReturn .= $this->getItemHtml($this->getItem($intIndex), $intIndex, $this->getHtmlAttribute('tabindex'), $this->blnWrapLabel) . "\n";
        }
        $strToReturn = $this->renderTag('div', ['id'=>$this->strControlId], null, $strToReturn);
        return $strToReturn;
    }

    /**
     * Adds an active class to the selected item at initial draw time. The bootstrap javascript will do change this
     * as the user clicks on the various buttons.
     *
     * @param $objItem
     * @param TagStyler $objItemAttributes
     * @param TagStyler $objLabelAttributes
     */
    protected function overrideItemAttributes($objItem, TagStyler $objItemAttributes, TagStyler $objLabelAttributes)
    {
        if ($objItem->Selected) {
            $objLabelAttributes->addCssClass("active");
        }
    }

    /**
     *
     */
    protected function refreshSelection()
    {
        $this->markAsModified();
    }

    /**
     * @param string $strName
     * @param string $mixValue
     * @throws Caller
     * @throws InvalidCast
     * @return void
     */
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            // APPEARANCE
            case "ButtonStyle":
                try {
                    $this->objItemStyle->removeCssClass($this->strButtonStyle);
                    $this->strButtonStyle = Type::cast($mixValue, Type::STRING);
                    $this->objItemStyle->addCssClass($this->strButtonStyle);
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            case "ButtonMode":    // inherited
                try {
                    if ($mixValue === self::BUTTON_MODE_SET) {
                        $this->objItemStyle->setCssClass("btn");
                        $this->objItemStyle->addCssClass($this->strButtonStyle);
                        parent::__set($strName, $mixValue);
                    }
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            default:
                try {
                    parent::__set($strName, $mixValue);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }
}
