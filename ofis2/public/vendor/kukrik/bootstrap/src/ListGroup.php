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
use QCubed\Control\Proxy;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Event;
use QCubed\Action;
use QCubed as Q;

/**
 * Class ListGroup
 * Implements a list group as a data repeater.
 * If you set SaveState = true, it will remember what was clicked and make it active.
 * Uses a proxy to display the items and process clicks.
 *
 * @property string $SelectedId
 *
 * @package QCubed\Bootstrap
 */
class ListGroup extends DataRepeater
{

    /** @var Proxy */
    protected $prxButton = null;

    protected $strSelectedItemId = null;

    protected $itemParamsCallback = null;

    /**
     * ListGroup constructor.
     * @param ControlBase|FormBase $objParentObject
     * @param null|string $strControlId
     * @throws Caller
     */
    public function __construct($objParentObject, $strControlId = null)
    {
        try {
            parent::__construct($objParentObject, $strControlId);
        } catch (Caller  $objExc) {
            $objExc->incrementOffset();
            throw $objExc;
        }

        $this->prxButton = new Proxy($this);
        $this->setup();
        $this->addCssClass("list-group");
    }


    /**
     * @throws Caller
     */
    protected function setup()
    {
        // Setup Pagination Events
        $this->prxButton->addAction(new Event\Click(), new Action\AjaxControl($this, 'itemClick'));
    }

    /**
     * Given an action, will make it a click action of an item. The item's id will be in the returned parameter.
     * @param \QCubed\Action\ActionBase $action
     * @throws Caller
     */
    public function addClickAction(Action\ActionBase $action)
    {
        $this->prxButton->addAction(new Event\Click(), $action);
    }

    /**
     * Uses the temaplate and/or HTML callback to get the inner html of each link.  Relies on the ItemParamsCallback
     * to return information on how to draw each item.
     *
     * @param mixed $objItem
     * @return string
     * @throws \Exception
     */
    protected function getItemHtml($objItem)
    {
        if (!$this->itemParamsCallback) {
            throw new \Exception("Must provide an itemParamsCallback");
        }

        $params = call_user_func($this->itemParamsCallback, $objItem, $this->intCurrentItemIndex);
        $strLabel = "";
        if (isset($params["html"])) {
            $strLabel = $params["html"];
        }
        $strId = "";
        if (isset($params["id"])) {
            $strId = $params["id"];
        }
        $strActionParam = $strId;
        if (isset($params["action"])) {
            $strActionParam = $params["action"];
        }

        $attributes = [];
        if (isset($params["attributes"])) {
            $attributes = $params["attributes"];
        }

        if (isset($attributes["class"])) {
            $attributes["class"] .= " list-group-item";
        } else {
            $attributes["class"] = "list-group-item";
        }

        if ($this->blnSaveState && $this->strSelectedItemId !== null && $this->strSelectedItemId == $strId) {
            $attributes["class"] .= " active";
        }
        $strLink = $this->prxButton->renderAsLink($strLabel, $strActionParam, $attributes, "a", false);

        return $strLink;
    }

    /**
     * An item in the list was clicked. This records what item was last clicked.
     *
     * @param array $params
     */
    public function itemClick($params)
    {
        if ($params) {
            $this->strSelectedItemId = $params[ControlBase::ACTION_PARAM];
            if ($this->blnSaveState) {
                $this->blnModified = true;
            }
        }
    }

    /**
     * @return mixed
     */
    protected function getState()
    {
        $state = parent::getState();
        if ($this->strSelectedItemId !== null) {
            $state["sel"] = $this->strSelectedItemId;
        }
        return $state;
    }

    /**
     * @param mixed $state
     */
    protected function putState($state)
    {
        if (isset($state["sel"])) {
            $this->strSelectedItemId = $state["sel"];
        }
        parent::putState($state);
    }

    /**
     * Set the item params callback. The callback should be of the form:
     *  func($objItem, $intCurrentItemIndex)
     * The callback will be give the current item from the data source, and the item's index visually.
     * The function should return a key/value array with the following possible items:
     *	html - the html to display as the innerHtml of the row.
     *  id - the id for the row tag
     *  attributes - Other attributes to put in the row tag.
     *
     * The callback is a callable, so can be of the form [$objControl, "func"]
     *
     * The row will automatically be given a class of "list-group-item", and the active row will also get the "active" class.
     *
     * @param callable $callback
     */
    public function setItemParamsCallback(callable $callback)
    {
        $this->itemParamsCallback = $callback;
    }

    public function sleep()
    {
        $this->itemParamsCallback = Q\Project\Control\ControlBase::sleepHelper($this->itemParamsCallback);
        parent::sleep();
    }

    /**
     * The object has been unserialized, so fix up pointers to embedded objects.
     * @param FormBase $objForm
     */
    public function wakeup(FormBase $objForm)
    {
        parent::wakeup($objForm);
        $this->itemParamsCallback = Q\Project\Control\ControlBase::wakeupHelper($objForm, $this->itemParamsCallback);
    }

    /**
     * @param string $strName
     * @param string $mixValue
     * @throws InvalidCast
     * @throws \Exception
     * @throws Caller
     * @throws InvalidCast
     * @return void
     */
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case 'SelectedId':
                $this->blnModified = true;
                $this->strSelectedItemId = $mixValue; // could be string or integer
                break;

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

    /**
     * @param string $strName
     * @return int|mixed|null|string
     * @throws Caller
     * @throws \Exception
     * @throws Caller
     */
    public function __get($strName)
    {
        switch ($strName) {
            case 'SelectedId':
                return $this->strSelectedItemId;

            default:
                try {
                    return parent::__get($strName);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }
}
