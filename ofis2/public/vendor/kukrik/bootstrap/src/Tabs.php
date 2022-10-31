<?php

namespace QCubed\Bootstrap;

use QCubed\Control\ControlBase;
use QCubed\Html;
use QCubed\QString;

class Tabs extends \QCubed\Project\Control\ControlBase
{
    protected $strSelectedId;

    public function validate()
    {
        return true;
    }

    public function parsePostData()
    {
    }

    public function getControlHtml()
    {
        $strHtml = '';
        foreach ($this->objChildControlArray as $objChildControl) {
            $strInnerHtml = Html::renderTag('a',
                [
                    'href' => '#' . $objChildControl->ControlId . '_tab',
                    'aria-controls' => $objChildControl->ControlId . '_tab',
                    'role' => 'tab',
                    'data-toggle' => 'tab'
                ],
                QString::htmlEntities($objChildControl->Name)
            );
            $attributes = ['role' => 'presentation'];
            if ($objChildControl->ControlId == $this->strSelectedId) {
                $attributes['class'] = 'active';
            }

            $strTag = Html::renderTag('li', $attributes, $strInnerHtml);
            $strHtml .= $strTag;
        }
        $strHtml = Html::renderTag('ul', ['class' => 'nav nav-tabs', 'role' => 'tablist'], $strHtml);

        $strInnerHtml = '';
        foreach ($this->objChildControlArray as $objChildControl) {
            $class = 'tab-pane';
            $strItemHtml = null;
            if ($objChildControl->ControlId == $this->strSelectedId) {
                $class .= ' active';
            }
            $strItemHtml = $objChildControl->render(false);

            $strInnerHtml .= Html::renderTag('div',
                [
                    'role' => 'tabpanel',
                    'class' => $class,
                    'id' => $objChildControl->ControlId . '_tab'
                ],
                $strItemHtml
            );
        }
        $strTag = Html::renderTag('div', ['class' => 'tab-content'], $strInnerHtml);

        $strHtml .= $strTag;

        $strTag = $this->renderTag('div', null, null, $strHtml);

        return $strTag;
    }

    public function addChildControl(ControlBase $objControl)
    {
        parent::addChildControl($objControl);
        if (count($this->objChildControlArray) == 1) {
            $this->strSelectedId = $objControl->ControlId;    // default to first item added being selected
        }
    }
}
