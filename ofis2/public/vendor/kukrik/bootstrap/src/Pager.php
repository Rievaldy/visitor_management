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
use QCubed\Control\PaginatorBase;
use QCubed\Exception\Caller;
use QCubed\Html;
use QCubed\Type;

/**
 * Class Pager
 *
 * A simple bootstrap paginator that works more like a pager than a paginator. Shows next and previous arrows, and
 * a page number.
 *
 * We use the pagination class rather than the pager class, because the bootstrap pager has some issues with vertical alignment when
 * using the previous and next classes. The pagination class gives a more pleasing presentation.
 *
 * @property bool $AddArrow add the arrow to the previous and next buttons
 * @property bool $Spread Spread the buttons out rather than bunch them
 * @property-write int $Size One of SMALL, MEDIUM or LARGE to specify how to draw the paginator buttons
 * @package QCubed\Bootstrap
 */
class Pager extends PaginatorBase
{
    /** @var bool Add an arrow to the previous and next buttons */
    protected $blnAddArrow = false;
    /** @var bool Set the buttons to the left and right side of the parent object, vs. bunched in the middle */
    protected $blnSpread = true;

    /** @var int  */
    protected $intSize = self::MEDIUM;

    const SMALL = 1;
    const MEDIUM = 2;
    const LARGE = 3;

    /**
     * Pager constructor.
     * @param ControlBase|FormBase $objParent
     * @param null $strControlId
     */
    public function __construct($objParent, $strControlId = null)
    {
        parent::__construct($objParent, $strControlId);

        // Default to a very compat format.
        $this->strLabelForPrevious = '&laquo;';
        $this->strLabelForNext = '&raquo;';
    }

    /**
     * @return string
     */
    protected function getPreviousButtonsHtml()
    {
        $strClasses = "";
        if ($this->blnSpread) {
            $strClasses = "previous";
        }
        $strLabel = $this->strLabelForPrevious;
        if ($this->blnAddArrow) {
            $strLabel = '<span aria-hidden="true">&larr;</span> ' . $strLabel;
        }
        if ($this->intPageNumber <= 1) {
            $strButton = Html::renderTag("a", ["href"=>"#"], $strLabel);
            $strClasses .= " disabled";
        } else {
            $this->mixActionParameter = $this->intPageNumber - 1;
            $strButton = $this->prxPagination->renderAsLink($strLabel, $this->mixActionParameter, ['id'=>$this->ControlId . "_arrow_" . $this->mixActionParameter], "a", false);
        }

        return Html::renderTag("li", ["class"=>$strClasses], $strButton);
    }

    /**
     * @return string
     */
    protected function getNextButtonsHtml()
    {
        $strClasses = "";
        if ($this->blnSpread) {
            $strClasses = "next";
        }
        $strLabel = $this->strLabelForNext;
        if ($this->blnAddArrow) {
            $strLabel = $strLabel . ' <span aria-hidden="true">&rarr;</span>' ;
        }
        if ($this->intPageNumber >= $this->PageCount) {
            $strButton = Html::renderTag("a", ["href"=>"#"], $strLabel);
            $strClasses .= " disabled";
        } else {
            $this->mixActionParameter = $this->intPageNumber + 1;
            $strButton = $this->prxPagination->renderAsLink($strLabel, $this->mixActionParameter, ['id'=>$this->ControlId . "_arrow_" . $this->mixActionParameter], "a", false);
        }

        return Html::renderTag("li", ["class"=>$strClasses], $strButton);
    }

    /**
     * @return string
     */
    public function getControlHtml()
    {
        $this->objPaginatedControl->dataBind();

        $strPager = $this->getPreviousButtonsHtml();
        $strLabel = Html::renderTag("a", ["href"=>"#"], $this->intPageNumber . ' ' .  t("of") . ' ' . $this->PageCount);
        $strPager .= Html::renderTag("li", ["class"=>"disabled"], $strLabel);
        $strPager .= $this->getNextButtonsHtml();
        $strClass = "pagination";
        if ($this->intSize == self::SMALL) {
            $strClass .= " pagination-sm";
        } elseif ($this->intSize == self::LARGE) {
            $strClass .= " pagination-lg";
        }
        $strPager = Html::renderTag("ul", ["class"=>$strClass], $strPager);

        return Html::renderTag("nav", $this->renderHtmlAttributes(), $strPager);
    }

    /**
     * @param string $strName
     * @return mixed
     * @throws Caller
     */
    public function __get($strName)
    {
        switch ($strName) {
            case 'AddArrow': return $this->blnAddArrow;
            case 'Spread': return $this->blnSpread;
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
            case 'AddArrow':
                try {
                    $this->blnAddArrow = Type::cast($mixValue, Type::BOOLEAN);
                    break;
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
            case 'Spread':
                try {
                    $this->blnSpread = Type::cast($mixValue, Type::BOOLEAN);
                    break;
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
            case 'Size':
                try {
                    $this->intSize = Type::cast($mixValue, Type::INTEGER);
                    break;
                } catch (Caller $objExc) {
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
