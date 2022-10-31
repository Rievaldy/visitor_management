<?php

namespace QCubed\Plugin;

use QCubed as Q;
use QCubed\Control;
use QCubed\Bootstrap as Bs;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\ModelConnector\Param as QModelConnectorParam;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Application;
use QCubed\Type;

/**
 * Class ClockPickerGen
 *
 * @see ClockPickerBase
 * @package QCubed\Plugin
 */

/**
 * @property string $Default	Default: '' (default time, 'now' or '13:14' e.g.)
 * @property string $Placement Default: 'bottom'	(popover placement)
 * @property string $Align Default: 'left' (popover arrow align)
 * @property string $DoneText For example, type 'Done' (done button text)
 * @property boolean $AutoClose Default: false (auto close when minute is selected)
 * @property boolean $Vibrate Default: true (vibrate the device when dragging clock hand)
 * @property string $FromNow Default: 0 Set default time to * milliseconds from now (using with default = 'now')
 * @property boolean $TwelveHour Default: false Enables twelve hour mode with AM & PM buttons
 *
 * @see http://weareoutman.github.io/clockpicker/ or https://github.com/weareoutman/clockpicker
 * @package QCubed\Plugin
 */

class ClockPickerBaseGen extends Bs\TextBox
{
    /** @var string */
    protected $strDefault = null;
    /** @var string */
    protected $strPlacement = null;
    /** @var string */
    protected $strAlign = null;
    /** @var string */
    protected $strDoneText = null;
    /** @var boolean */
    protected $blnAutoClose = null;
    /** @var boolean */
    protected $blnVibrate = null;
    /** @var string */
    protected $strFromNow = null;
    /** @var boolean */
    protected $blnTwelveHour = null;

    protected function makeJqOptions()
    {
        $jqOptions = parent::MakeJqOptions();
        if (!is_null($val = $this->Default)) {$jqOptions['default'] = $val;}
        if (!is_null($val = $this->Placement)) {$jqOptions['placement'] = $val;}
        if (!is_null($val = $this->Align)) {$jqOptions['align'] = $val;}
        if (!is_null($val = $this->DoneText)) {$jqOptions['donetext'] = $val;}
        if (!is_null($val = $this->AutoClose)) {$jqOptions['autoclose'] = $val;}
        if (!is_null($val = $this->Vibrate)) {$jqOptions['vibrate'] = $val;}
        if (!is_null($val = $this->FromNow)) {$jqOptions['fromnow'] = $val;}
        if (!is_null($val = $this->TwelveHour)) {$jqOptions['twelvehour'] = $val;}
        return $jqOptions;
    }

    public function getJqSetupFunction()
    {
        return 'clockpicker';
    }

    /**
     * Show the clockpicker.
     *
     * This method does not accept any arguments.
     */
    public function show()
    {
        Application::executeControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "show", Application::PRIORITY_LOW);
    }

    /**
     * Hide the clockpicker.
     *
     * This method does not accept any arguments.
     */
    public function hide()
    {
        Application::executeControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "hide", Application::PRIORITY_LOW);
    }

    /**
     * Remove the clockpicker (and event listeners).
     *
     * This method does not accept any arguments.
     */
    public function remove()
    {
        Application::executeControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "remove", Application::PRIORITY_LOW);
    }

    public function __get($strName)
    {
        switch ($strName) {
            case 'Default': return $this->strDefault;
            case 'Placement': return $this->strPlacement;
            case 'Align': return $this->strAlign;
            case 'DoneText': return $this->strDoneText;
            case 'AutoClose': return $this->blnAutoClose;
            case 'Vibrate': return $this->blnVibrate;
            case 'FromNow': return $this->strFromNow;
            case 'TwelveHour': return $this->blnTwelveHour;

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
            case 'Default':
                try {
                    $this->strDefault = Type::Cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'default', $this->strDefault);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Placement':
                try {
                    $this->strPlacement = Type::Cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'placement', $this->strPlacement);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Align':
                try {
                    $this->strAlign = Type::Cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'align', $this->strAlign);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'DoneText':
                try {
                    $this->strDoneText = Type::Cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'donetext', $this->strDoneText);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'AutoClose':
                try {
                    $this->blnAutoClose = Type::Cast($mixValue, Type::BOOLEAN);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'autoclose', $this->blnAutoClose);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Vibrate':
                try {
                    $this->blnVibrate = Type::Cast($mixValue, Type::INTEGER);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'vibrate', $this->blnVibrate);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'FromNow':
                try {
                    $this->strFromNow = Type::Cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'fromnow', $this->strFromNow);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'TwelveHour':
                try {
                    $this->blnTwelveHour = Type::Cast($mixValue, Type::BOOLEAN);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'twelvehour', $this->blnTwelveHour);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }


            default:
                try {
                    parent::__set($strName, $mixValue);
                    break;
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }

    /**
     * If this control is attachable to a codegenerated control in a ModelConnector, this function will be
     * used by the ModelConnector designer dialog to display a list of options for the control.
     * @return QModelConnectorParam[]
     **/
    public static function getModelConnectorParams()
    {
        return array_merge(parent::GetModelConnectorParams(), array());
    }
}


