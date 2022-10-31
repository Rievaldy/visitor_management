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
use QCubed\Html;

/**
 * Class Checkbox
 *
 * Outputs a bootstrap style checkbox
 *
 * @property-write boolean $Inline whether checkbox should be displayed inline or wrapped in a div
 * @package QCubed\Bootstrap
 */
class Checkbox extends \QCubed\Project\Control\Checkbox
{
    protected $blnInline = false;
    protected $blnWrapLabel = true;

    /**
     * @param $attrOverride
     * @return string
     */
    protected function renderButton($attrOverride)
    {
        if (!$this->blnInline) {
            $strHtml = parent::renderButton($attrOverride);
            return Html::renderTag('div', ['class'=>'checkbox'], $strHtml);
        }
        return parent::renderButton($attrOverride);
    }

    /**
     * @return string
     */
    protected function renderLabelAttributes()
    {
        if ($this->blnInline) {
            $this->getCheckLabelStyler()->addCssClass(Bootstrap::CHECKBOX_INLINE);
        }
        return parent::renderLabelAttributes();
    }

    /**
     * @param string $strText
     * @param string $mixValue
     * @throws Caller
     * @throws InvalidCast
     * @return void
     */
    public function __set($strText, $mixValue) {
        switch ($strText) {
            case "Inline":
                try {
                    $this->blnInline = Type::cast($mixValue, Type::BOOLEAN);
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
