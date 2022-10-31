<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;

/**
 * TextBox
 * Text boxes can be parts of input groups (implemented), and can have feedback icons (not yet implemented).
 *
 * Two ways to create a textbox with input groups: Either use this class, or use the InputGroup trait in your base
 * \QCubed\Project\Control\TextBox class.
 *
 * @property string $SizingClass Bootstrap::InputGroupLarge, Bootstrap::InputGroupMedium or Bootstrap::InputGroupSmall
 * @property string $LeftText Text to appear to the left of the input item.
 * @property string $RightText Text to appear to the right of the input item.
 *
 */

class TextBox extends \QCubed\Project\Control\TextBox
{
    use InputGroupTrait;

    public function __construct($objParent, $strControlId = null)
    {
        parent::__construct($objParent, $strControlId);

        Bootstrap::loadJS($this);

        $this->addCssClass(Bootstrap::FORM_CONTROL);
    }


    protected function getControlHtml()
    {
        $strToReturn = parent::getControlHtml();

        return $this->wrapInputGroup($strToReturn);
    }

    public function __get($strName)
    {
        switch ($strName) {
            case "SizingClass": return $this->sizingClass();
            case "LeftText": return $this->leftText();
            case "RightText": return $this->rightText();
            default:
                try {
                    return parent::__get($strName);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }

    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case "SizingClass": // Bootstrap::InputGroupLarge, Bootstrap::InputGroupMedium or Bootstrap::InputGroupSmall
                try {
                    $this->setSizingClass($mixValue);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case "LeftText":
                try {
                    $this->setLeftText($mixValue);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case "RightText":
                try {
                    $this->setRightText($mixValue);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

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
