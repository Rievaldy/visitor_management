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
 * Class Paginator
 *
 * A bootstrap implementation of the QCubed paginator.
 *
 * @property bool $AddArrow whether to add arrows to the buttons
 * @property-write int $Size SMALL, MEDIUM or LARGE buttons
 *
 * @package QCubed\Bootstrap
 */
class Paginator extends PaginatorBase
{
    /** @var bool Add an arrow to the previous and next buttons */
    protected $blnAddArrow = false;
    protected $strTag = 'nav';

    protected $intSize = 2;

    const SMALL = 1;
    const MEDIUM = 2;
    const LARGE = 3;

    /**
     * Paginator constructor.
     * @param FormBase|ControlBase $objParent
     * @param null|string $strControlId
     */
    public function __construct($objParent, $strControlId = null)
    {
        parent::__construct($objParent, $strControlId);

        // Default to a very compact format.
        $this->strLabelForPrevious = '&laquo;';
        $this->strLabelForNext = '&raquo;';
    }

    /**
     * @return string
     */
    protected function getPreviousButtonsHtml()
    {
        list($intPageStart, $intPageEnd) = $this->calcBunch();

        $strClasses = "";
        $strLabel = $this->strLabelForPrevious;
        if ($this->blnAddArrow) {
            $strLabel = '<span aria-hidden="true">&larr;</span> ' . $strLabel;
        }
        if ($this->intPageNumber <= 1) {
            $strButton = Html::renderTag("span", ["aria-label"=>"Previous"], $strLabel);
            $strClasses .= " disabled";
        } else {
            $this->mixActionParameter = $this->intPageNumber - 1;
            $strButton = $this->prxPagination->renderAsLink($strLabel, $this->mixActionParameter, ["aria-label"=>"Previous", 'id'=>$this->ControlId . "_arrow_" . $this->mixActionParameter], "a", false);
        }

        $strHtml = Html::renderTag("li", ["class"=>$strClasses], $strButton);

        if ($intPageStart != 1) {
            $strHtml .= $this->getPageButtonHtml(1);
            $strHtml .= Html::renderTag("li", ["class"=>'disabled'], "<span>&hellip;</span>");
        }
        return $strHtml;
    }

    /**
     * @return string
     */
    protected function getNextButtonsHtml()
    {
        list($intPageStart, $intPageEnd) = $this->calcBunch();

        $intPageCount = $this->PageCount;
        $strClasses = "";
        $strLabel = $this->strLabelForNext;
        if ($this->blnAddArrow) {
            $strLabel = $strLabel . ' <span aria-hidden="true">&rarr;</span>' ;
        }
        if ($this->intPageNumber >= $intPageCount) {
            $strButton = Html::renderTag("span", ["aria-label"=>"Next"], $strLabel);
            $strClasses .= " disabled";
        } else {
            $this->mixActionParameter = $this->intPageNumber + 1;
            $strButton = $this->prxPagination->renderAsLink($strLabel, $this->mixActionParameter, ["aria-label"=>"Next", 'id'=>$this->ControlId . "_arrow_" . $this->mixActionParameter], "a", false);
        }

        $strHtml = Html::renderTag("li", ["class"=>$strClasses], $strButton);

        if ($intPageEnd != $intPageCount) {
            $strHtml = $this->getPageButtonHtml($intPageCount) . $strHtml;
            $strHtml = Html::renderTag("li", ["class"=>'disabled'], "<span>&hellip;</span>") . $strHtml;
        }

        return $strHtml;
    }

    /**
     * @param int $intIndex
     * @return string
     */
    protected function getPageButtonHtml($intIndex)
    {
        if ($this->intPageNumber == $intIndex) {
            $strToReturn = Html::renderTag("li", ["class"=>"active"], '<span>' . $intIndex . '<span class="sr-only">(current)</span></span>');
        } else {
            $mixActionParameter = $intIndex;
            $strToReturn = $this->prxPagination->renderAsLink($intIndex, $mixActionParameter, ['id'=>$this->ControlId . "_page_" . $mixActionParameter]);
            $strToReturn = Html::renderTag("li", [], $strToReturn);
        }
        return $strToReturn;
    }

    /**
     * @return string
     */
    public function getControlHtml()
    {
        $this->objPaginatedControl->dataBind();

        $strToReturn = $this->getPreviousButtonsHtml();

        list($intPageStart, $intPageEnd) = $this->calcBunch();

        for ($intIndex = $intPageStart; $intIndex <= $intPageEnd; $intIndex++) {
            $strToReturn .= $this->getPageButtonHtml($intIndex);
        }

        $strToReturn .= $this->getNextButtonsHtml();
        $strClass = "pagination";
        if ($this->intSize == self::SMALL) {
            $strClass .= " pagination-sm";
        } elseif ($this->intSize == self::LARGE) {
            $strClass .= " pagination-lg";
        }

        $strToReturn = Html::renderTag("ul", ["class"=>$strClass], $strToReturn);

        return Html::renderTag($this->strTag, $this->renderHtmlAttributes(), $strToReturn);
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
