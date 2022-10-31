<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\Panel;
use QCubed\Html;
use QCubed\QString;
use QCubed\Type;

/**
 * Class InputGroupTrait
 *
 * Adds input group functionality to a control. Specifically designed for \QCubed\Project\Control\TextBox controls and subclasses.
 *
 * @package QCubed\Bootstrap
 */
trait InputGroupTrait
{
    /** @var  string|null */
    protected $strSizingClass;
    /** @var  string|null */
    protected $strLeftText;
    /** @var  string|null */
    protected $strRightText;
    /** @var bool */
    protected $blnInputGroup = false;    // for subclasses
    /** @var  Panel|null */
    protected $pnlLeftButtons;
    /** @var  Panel|null */
    protected $pnlRightButtons;

    /**
     * Wraps the give code with an input group tag.
     *
     * @param $strControlHtml
     * @return string
     */
    protected function wrapInputGroup($strControlHtml)
    {
        if ($this->strLeftText ||
            $this->strRightText ||
            $this->blnInputGroup ||
            $this->pnlLeftButtons ||
            $this->pnlRightButtons
        ) {
            $strClass = 'input-group';
            if ($this->strSizingClass) {
                Html::addClass($strClass, $this->strSizingClass);
            }

            $strControlHtml = Html::renderTag('div', ['class' => $strClass],
                $this->getLeftHtml() .
                $strControlHtml .
                $this->getRightHtml());
        }

        return $strControlHtml;
    }

    /**
     * @return string
     */
    protected function getLeftHtml()
    {
        if ($this->strLeftText) {
            return sprintf('<span class="input-group-addon">%s</span>', QString::htmlEntities($this->strLeftText));
        } elseif ($this->pnlLeftButtons) {
            return $this->pnlLeftButtons->render(false);
        }
        return '';
    }

    /**
     * @return string
     */
    protected function getRightHtml()
    {
        if ($this->strRightText) {
            return sprintf('<span class="input-group-addon">%s</span>', QString::htmlEntities($this->strRightText));
        } elseif ($this->pnlRightButtons) {
            return $this->pnlRightButtons->render(false);
        }
        return '';
    }

    /**
     * @return null|string
     */
    public function sizingClass()
    {
        return $this->strSizingClass;
    }

    /**
     * @return null|string
     */
    public function leftText()
    {
        return $this->strLeftText;
    }

    /**
     * @return null|string
     */
    public function rightText()
    {
        return $this->strRightText;
    }

    /**
     * @return void
     */
    abstract public function markAsModified();

    /**
     * @param string $strSizingClass
     */
    public function setSizingClass($strSizingClass)
    {
        $strSizingClass = Type::cast($strSizingClass, Type::STRING);
        if ($strSizingClass != $this->strSizingClass) {
            $this->markAsModified();
            $this->strSizingClass = $strSizingClass;
        }
    }

    /**
     * @param string $strLeftText
     */
    public function setLeftText($strLeftText)
    {
        $strText = Type::cast($strLeftText, Type::STRING);
        if ($strText != $this->strLeftText) {
            $this->markAsModified();
            $this->strLeftText = $strText;
        }
    }

    /**
     * @param string $strRightText
     */
    public function setRightText($strRightText)
    {
        $strText = Type::cast($strRightText, Type::STRING);
        if ($strText != $this->strRightText) {
            $this->markAsModified();
            $this->strRightText = $strText;
        }
    }

    /**
     * @param Panel $panel
     */
    public function setLeftButtonPanel(Panel $panel)
    {
        $panel->addCssClass('input-group-btn');
        $this->pnlLeftButtons = $panel;
    }

    /**
     * @param Panel $panel
     */
    public function setRightButtonPanel(Panel $panel)
    {
        $panel->addCssClass('input-group-btn');
        $this->pnlRightButtons = $panel;
    }

}
