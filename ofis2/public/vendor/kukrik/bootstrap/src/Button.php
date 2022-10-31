<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Exception\InvalidCast;
use QCubed\Type;


/**
 * Class Button
 * Bootstrap styled buttons
 *
 * @package QCubed\Bootstrap
 */
class Button extends \QCubed\Project\Control\Button
{
    protected $strButtonStyle = Bootstrap::BUTTON_DEFAULT;
    protected $strCssClass = "btn btn-default";
    protected $strButtonSize = '';
    protected $strGlyph;

    public function setStyleClass($strStyleClass)
    {
        $this->removeCssClass($this->strButtonStyle);
        $this->strButtonStyle = Type::cast($strStyleClass, Type::STRING);
        $this->addCssClass($this->strButtonStyle);
    }

    public function setSizeClass($strSizeClass)
    {
        $this->removeCssClass($this->strButtonStyle);
        $this->strButtonSize = Type::cast($strSizeClass, Type::STRING);
        $this->addCssClass($this->strButtonSize);
    }

    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case "StyleClass":    // One of Bootstrap::ButtonDefault, ButtonPrimary, ButtonSuccess, ButtonInfo, ButtonWarning, ButtonDanger
                $this->setStyleClass($mixValue);
                break;

            case "SizeClass": // One of Bootstrap::ButtonLarge, ButtonMedium, ButtonSmall, ButtonExtraSmall
                $this->setSizeClass($mixValue);
                break;

            case "Glyph": // One of the glyph icons
                $this->strGlyph = Type::cast($mixValue, Type::STRING);
                break;

            case "PrimaryButton":
                try {
                    $this->blnPrimaryButton = Type::cast($mixValue, Type::BOOLEAN);
                    $this->setStyleClass(Bootstrap::BUTTON_PRIMARY);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }


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

    protected function getInnerHtml()
    {
        $strToReturn = parent::getInnerHtml();
        if ($this->strGlyph) {
            $strToReturn = sprintf('<span class="glyphicon %s" aria-hidden="true"></span>', $this->strGlyph) . $strToReturn;
        }
        return $strToReturn;
    }
}
