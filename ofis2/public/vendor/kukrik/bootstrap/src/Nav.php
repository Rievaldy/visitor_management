<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

include_once("Bootstrap.php");


use QCubed\Bootstrap\Event\NavSelect;
use QCubed\Control\ControlBase;
use QCubed\Control\FormBase;
use QCubed\Control\HList;
use QCubed\Control\HListItem;
use QCubed\Control\ListItemStyle;
use QCubed\Exception\Caller;
use QCubed\Html;
use QCubed\Action;
use QCubed\QString;
use QCubed\Type;

/**
 * Class Nav
 *
 * This Bootstrap Nav has many modes of operation, and can implement a Nav panel as described in the the Bootstrap
 * Components documentation, or a Tabs panel as described in the Bootstrap Javascript documentation.
 *
 * The simplest way to use it is to simply add Panels to the control as child controls. Give each panel a Name, and
 * that will create a Tab panel.
 *
 * If you are just creating a Nav, or want more control of what is displayed, use the \QCubed\Control\HList functionality to
 * add items. The items will be drawn as Navs.
 *
 * @property string $ButtonStyle Either Bootstrap::NavPills or Bootstrap::NavTabs
 * @property bool $Justified True to justify the items.
 *
 * @package QCubed\Bootstrap
 */
class Nav extends HList
{
    /** @var  string */
    protected $strActiveItemId;
    /** @var  string */
    protected $strButtonStyle;
    /** @var  bool */
    protected $blnJustified;

    /**
     * Nav constructor.
     * @param ControlBase|FormBase $objParent
     * @param null|string $strControlId
     */
    public function __construct($objParent, $strControlId = null)
    {
        parent::__construct($objParent, $strControlId);

        $this->addCssClass('nav nav-tabs');    // default to tabs
        $this->setHtmlAttribute('role', 'tablist');

        $this->objItemStyle = new ListItemStyle();
        $this->objItemStyle->setHtmlAttribute('role', 'presentation');

        $this->addAction(new NavSelect(), new Action\AjaxControl($this, 'tab_Click'));

        $this->blnUseWrapper = true;    // since its a compound control, a wrapper is required if redraw is forced.
        $this->blnIsBlockElement = true;
        Bootstrap::loadJS($this);
    }

    /**
     * @param HListItem $objItem
     * @return ListItemStyle
     */
    protected function getItemStyler($objItem)
    {
        $objStyler = parent::getItemStyler($objItem);

        //if no item is active, pick the first item in the list to be active
        if ($this->strActiveItemId === null) {
            $this->strActiveItemId = $objItem->Id;
        }

        if ($objItem->Id === $this->strActiveItemId) {
            $objStyler->addCssClass('active');
        }
        return $objStyler;
    }

    /**
     * @param HListItem $objItem
     * @return string
     */
    protected function getItemText($objItem)
    {
        $strHtml = QString::htmlEntities($objItem->Text);

        if ($strAnchor = $objItem->Anchor) {
            $attributes['href'] = '#' . $strAnchor;
            $attributes['aria-controls'] = $strAnchor;
        }
        $attributes['role'] = 'tab';
        $attributes['data-toggle'] = 'tab';

        $strHtml = Html::renderTag('a',
                $attributes,
                $strHtml, false, true);
        return $strHtml;
    }

    /**
     * A tab was clicked. Records the value of the clicked tab.
     *
     * @param array $params
     */
    protected function tab_Click($params)
    {
        $this->strActiveItemId = $params[ControlBase::ACTION_PARAM];
    }

    /**
     * Returns the HTML for the control and all subitems. If no items or panels are added, nothing will be drawn.
     *
     * @return string
     */
    public function getControlHtml()
    {
        if ($this->hasDataBinder()) {
            $this->callDataBinder();
        }
        $strHtml = $this->renderNav();
        $strHtml .= $this->renderPanels();

        if ($this->hasDataBinder()) {
            $this->removeAllItems();
        }

        return $strHtml;
    }

    /**
     * Renders the nav tag.
     *
     * @return string
     */
    protected function renderNav()
    {
        $strHtml = '';

        // If items are present, use them
        if ($this->getItemCount()) {
            foreach ($this->getAllItems() as $objItem) {
                $strHtml .= $this->getItemHtml($objItem);
            }
        } else {    // Otherwise, use the names of child panels
            foreach ($this->getChildControls() as $objControl) {
                $strHtml .= $this->renderChildPanelName($objControl);
            }
        }
        if ($strHtml) {
            $strHtml = $this->renderTag($this->strTag, null, null, $strHtml);
        }
        return $strHtml;
    }

    /**
     * Renders the child panels as follow on panes.
     *
     * @param ControlBase $objControl
     * @return string
     */
    protected function renderChildPanelName(ControlBase $objControl)
    {
        if ($this->strActiveItemId === null) {
            $this->strActiveItemId = $objControl->ControlId;
        }

        $strAnchor = Html::renderTag('a', ['href'=>'#' . $objControl->ControlId . "_tab", 'aria-controls'=>$objControl->ControlId, 'role'=>'tab', 'data-toggle'=>'tab'], $objControl->Name, false, true);
        $attributes['role']='presentation';
        if ($objControl->ControlId === $this->strActiveItemId) {
            $attributes['class'] = 'active';
        }
        $strHtml = Html::renderTag('li', $attributes, $strAnchor);
        return $strHtml;
    }

    /**
     * @return string
     * @throws \Exception
     * @throws Caller
     */
    protected function renderPanels()
    {
        $strHtml = '';
        foreach ($this->getChildControls() as $objControl) {
            // Render each child control inside a tab pane, so that child control can have a wrapper if desired.
            $attr['role'] = 'tabpanel';
            $attr['class'] = 'tab-pane';
            if ($objControl->ControlId === $this->strActiveItemId) {
                $attr['class'] .= ' active';
            }
            $attr['id'] = $objControl->ControlId . "_tab";
            $strHtml .= Html::renderTag('div', $attr, $objControl->render(false));
        }

        $attributes['class'] = 'tab-content';
        if ($this->hasCssClass(Bootstrap::NAV_TABS)) {
            $attributes['class'] .= ' qbstabs-content';
        } else {
            $attributes['class'] .= ' qbspills-content';
        }
        if (!empty($strHtml)) {
            $strHtml = Html::renderTag('div', $attributes, $strHtml);
        }
        return $strHtml;
    }

    /**
     * @param string $strName
     * @return mixed
     * @throws Caller
     * @throws \Exception
     * @throws Caller
     */
    public function __get($strName)
    {
        switch ($strName) {
            case 'ButtonStyle': return $this->strButtonStyle;
            case 'Justified': return $this->blnJustified;
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
     * @throws \Exception
     * @throws Caller
     * @throws \QCubed\Exception\InvalidCast
     * @return void
     */
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case 'ButtonStyle':
                try {
                    $buttonStyle = Type::cast($mixValue, Type::STRING);
                    $this->removeCssClass(Bootstrap::NAV_PILLS);
                    $this->removeCssClass(Bootstrap::NAV_TABS);
                    $this->addCssClass($buttonStyle);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            case 'Justified':
                try {
                    $blnJustified = Type::cast($mixValue, Type::BOOLEAN);
                    if ($blnJustified) {
                        $this->addCssClass(Bootstrap::NAV_JUSTIFIED);
                    } else {
                        $this->removeCssClass(Bootstrap::NAV_JUSTIFIED);
                    }
                } catch (Caller $objExc) {
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
                break;
        }
    }
}
