<?php

namespace QCubed\Plugin;

use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\QDateTime;
use QCubed\Type;

/**
 * Class ClockPickerBase
 *
 * @property null|QDateTime $DateTime
 *
 * @package QCubed\Plugin
 */

class ClockPickerBase extends ClockPickerBaseGen
{

    protected $strLabelForInvalid = 'Invalid Time';

    protected $strText;

    /**
     * @param $strText
     * @return null|QDateTime
     */
    public static function ParseForTimeValue($strText) {
        // Trim and Clean

        $strText = strtolower(trim($strText));
        while(strpos($strText, '  ') !== false)
            $strText = str_replace('  ', ' ', $strText);
        $strText = str_replace('.', '', $strText);
        $strText = str_replace('@', ' ', $strText);

        // Are we ATTEMPTING to parse a Time value?
        if ((strpos($strText, ':') === false) &&
            (strpos($strText, 'am') === false) &&
            (strpos($strText, 'pm') === false)) {
            // There is NO TIME VALUE
            return null;
        }

        // Add ':00' if it doesn't exist AND if 'am' or 'pm' exists
        if (strpos($strText, 'pm') !== false) {
            if (strpos($strText, ' pm') === false) {
                $strText = str_replace('pm', ' pm', $strText);
            }

            if (strpos($strText, ':') === false) {
                $strText = str_replace(' pm', ':00 pm', $strText, $intCount);
            }
        } else if ((strpos($strText, 'am') !== false)) {
            if (strpos($strText, ' am') === false) {
                $strText = str_replace('am', ' am', $strText);
            }
            if ((strpos($strText, ':') === false)) {
                $strText = str_replace(' am', ':00 am', $strText);
            }
        }

        $dttToReturn = new QDateTime($strText);
        return $dttToReturn;
    }

    public function validate() {
        if (parent::validate()) {
            if ($this->strText != "") {
                $dttTest = self::ParseForTimeValue($this->strText);
                if (!$dttTest) {
                    $this->ValidationError = $this->strLabelForInvalid;
                    return false;
                }
            }
        } else
            return false;

        $this->strValidationError = '';
        return true;
    }

    /**
     * @param string $strName
     * @return bool|mixed|null|string
     * @throws Caller
     */
    public function __get($strName)
    {
        switch ($strName) {
            case 'DateTime': return self::ParseForTimeValue($this->Text);
            case 'LabelForInvalid': return $this->strLabelForInvalid;

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
            case 'DateTime':
                try {
                    $dtt = Type::cast($mixValue, Type::DATE_TIME);
                    if ($dtt) {
                        $this->Text = $dtt->qFormat ("h:mm z");
                    } else {
                        $this->Text = '';
                    }
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            case 'LabelForInvalid':
                try {
                    return ($this->strLabelForInvalid = Type::Cast($mixValue, Type::STRING));
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

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
}