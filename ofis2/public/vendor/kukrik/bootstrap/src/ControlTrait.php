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
use QCubed\HtmlAttributeManagerBase;
use QCubed\Project\Control\Checkbox;
use QCubed\Project\Control\ListBox;
use QCubed\QString;
use QCubed\TagStyler;
use QCubed\Type;

/**
 * Class ControlTrait
 *
 * Base bootstrap control trait. The preferred method of adding bootstrap functionality is to make your Control class
 * inherit from the Control class in Control.class.php. Alternatively you can use this trait to make a control a
 * bootstrap control, but you have to be careful of method collisions. The best way to do this is probably to
 * use it in a derived class of the base class.
 *
 * @package QCubed\Bootstrap
 */
trait ControlTrait
{
    /** @var string|null */
    protected $strValidationState = null;
    /** @var TagStyler|null */
    protected $objLabelStyler = null;
    /** @var null|string */
    protected $strHorizontalClass = null;


    public function getLabelStyler()
    {
        if (!$this->objLabelStyler) {
            $this->objLabelStyler = new TagStyler();
            // initialize
            $this->objLabelStyler->addCssClass('control-label');
        }
        return $this->objLabelStyler;
    }

    public function addLabelClass($strNewClass)
    {
        $this->getLabelStyler()->addCssClass($strNewClass);
    }

    public function removeLabelClass($strCssClassName)
    {
        $this->getLabelStyler()->removeCssClass($strCssClassName);
    }

    /**
     * Adds a grid setting to the control.
     * Generally, you only should do this on \QCubed\Control\Panel type classes. HTML form object classes drawn with RenderFormGroup
     * should generally not be given a column class, but rather wrapped in a div with a column class setting. Or, if
     * you are trying to achieve labels next to control objects, see the directions at FormHorizontal class.
     *
     * @param $strDeviceSize
     * @param int $intColumns
     * @param int $intOffset
     * @param int $intPush
     * @return mixed
     */
    public function addColumnClass($strDeviceSize, $intColumns = 0, $intOffset = 0, $intPush = 0)
    {
        return ($this->addCssClass(Bootstrap::createColumnClass($strDeviceSize, $intColumns, $intOffset, $intPush)));
    }

    /**
     * Adds a class to the horizontal column classes, used to define the column breaks when drawing in a
     * horizontal mode.
     *
     * @param $strDeviceSize
     * @param int $intColumns
     * @param int $intOffset
     * @param int $intPush
     */
    public function addHorizontalColumnClass($strDeviceSize, $intColumns = 0, $intOffset = 0, $intPush = 0)
    {
        $strClass = Bootstrap::createColumnClass($strDeviceSize, $intColumns, $intOffset, $intPush);
        $blnChanged = Html::addClass($this->strHorizontalClass, $strClass);
        if ($blnChanged) {
            $this->markAsModified();
        }
    }


    /**
     * Removes all the column classes for a particular device size from the given class string.
     * @param $strHaystack
     * @param string $strDeviceSize Device size to search for. Default will remove all column classes for all device sizes.
     * @return string New class string with given column classes removed
     */
    public static function removeColumnClasses($strHaystack, $strDeviceSize = '')
    {
        $strTest = 'col-' . $strDeviceSize;
        $aRet = array();
        if ($strHaystack) {
            foreach (explode(' ', $strHaystack) as $strClass) {
                if (strpos($strClass, $strTest) !== 0) {
                    $aRet[] = $strClass;
                }
            }
        }
        return implode(' ', $aRet);
    }

    /**
     * A helper class to quickly set the size of the label part of an object, and the form control part of the object
     * for a particular device size. Bootstrap is divided into 12 columns, so whatever the label does not take is
     * left for the control.
     *
     * If the contrtol does not have a "Name", we will assume that the label will not be printed, so we will move the
     * control into the control side of things.
     *
     * @param $strDeviceSize
     * @param $intColumns
     */
    public function setHorizontalLabelColumnWidth($strDeviceSize, $intColumns)
    {
        $intCtrlCols = 12 - $intColumns;
        if ($this->Name) { // label next to control
            $this->addLabelClass(Bootstrap::createColumnClass($strDeviceSize, $intColumns));
            $this->addHorizontalColumnClass($strDeviceSize, $intCtrlCols);
        } else { // no label, so shift control to other column
            $this->addHorizontalColumnClass($strDeviceSize, 0, $intColumns);
            $this->addHorizontalColumnClass($strDeviceSize, $intCtrlCols);
        }
    }

    /**
     * Render the control in a form group, with a label, help text and error state.
     * This is somewhat tricky, as html is not consistent in its structure, and Bootstrap
     * has different ways of doing things too.
     *
     * @param bool $blnDisplayOutput
     * @return string
     * @throws \Exception
     * @throws Caller
     */
    public function renderFormGroup($blnDisplayOutput = true)
    {
        if ($this instanceof \QCubed\Project\Control\TextBox ||
            $this instanceof ListBox) {
            $this->addCssClass(Bootstrap::FORM_CONTROL); // make sure certain controls get a form control class
        }

        $this->blnUseWrapper = true;    // always use wrapper, because its part of the form group
        $this->getWrapperStyler()->addCssClass(Bootstrap::FORM_GROUP);

        $this->renderHelper(func_get_args(), __FUNCTION__);

        try {
            $strControlHtml = $this->getControlHtml();
        } catch (Caller $objExc) {
            $objExc->incrementOffset();
            throw $objExc;
        }

        $blnIncludeFor = false;
        // Try to automatically detect the correct value
        if ($this instanceof \QCubed\Project\Control\TextBox ||
            $this instanceof ListBox ||
            $this instanceof Checkbox) {
            $blnIncludeFor = true;
        }

        $strLabel = $this->renderLabel($blnIncludeFor) . "\n";

        $strHtml = $this->strHtmlBefore . $strControlHtml . $this->strHtmlAfter . $this->getHelpBlock();

        if ($this->strHorizontalClass) {
            $strHtml = Html::renderTag('div', ['class' => $this->strHorizontalClass], $strHtml);
        }

        $strHtml = $strLabel . $strHtml;

        return $this->renderOutput($strHtml, $blnDisplayOutput, true);
    }

    /**
     * Gets the Label tag contents just before drawing.
     * Controls that need manual control should override.
     * If no Name attribute is attached to the control, no label is generated.
     * @param bool $blnIncludeFor
     * @return string
     */
    public function renderLabel($blnIncludeFor = false)
    {
        if (!$this->strName) {
            return '';
        }

        $objLabelStyler = $this->getLabelStyler();
        $attrOverrides['id'] = $this->ControlId . '_label';

        if ($blnIncludeFor) {
            $attrOverrides['for'] = $this->ControlId;
        }

        return Html::renderTag('label', $objLabelStyler->renderHtmlAttributes($attrOverrides), QString::htmlEntities($this->strName), false, true);
    }

    protected function getHelpBlock()
    {
        $strHtml = "";
        if ($this->strValidationError) {
            $strHtml .= Html::renderTag('p', ['class'=>'help-block', 'id'=>$this->strControlId . '_error'], $this->strValidationError);
        } elseif ($this->strWarning) {
            $strHtml .= Html::renderTag('p', ['class'=>'help-block', 'id'=>$this->strControlId . '_warning'], $this->strWarning);
        } elseif ($this->strInstructions) {
            $strHtml .= Html::renderTag('p', ['class'=>'help-block', 'id'=>$this->strControlId . '_help'], $this->strInstructions);
        }
        return $strHtml;
    }


    /**
     * Returns the attributes for the control.
     * @param bool $blnIncludeCustom
     * @param bool $blnIncludeAction
     * @return string
     */
    public function renderHtmlAttributes($attributeOverrides = null, $styleOverrides = null)
    {
        if ($this->strValidationError) {
            $attributeOverrides['aria-describedby'] = $this->strControlId . '_error';
        } elseif ($this->strWarning) {
            $attributeOverrides['aria-describedby'] = $this->strControlId . '_warning';
        } elseif ($this->strInstructions) {
            $attributeOverrides['aria-describedby'] = $this->strControlId . '_help';
        }

        return parent::renderHtmlAttributes($attributeOverrides, $styleOverrides);
    }

    public function validationReset()
    {
        if ($this->strValidationState) {
            $this->removeWrapperCssClass($this->strValidationState);
            $this->strValidationState = null;
        }
        parent::validationReset();
    }

    /**
     * Since wrappers do not redraw on a validation error (only their contents redraw), we must use javascript to change
     * the wrapper class. Which is fine, since its faster.
     */
    public function reinforceValidationState()
    {
        $objChildControls = $this->getChildControls(false);
        if ($this->blnUseWrapper &&
                count($objChildControls) == 0) {    // don't apply states to parent controls
            if ($this->strValidationError) {
                $this->addWrapperCssClass(Bootstrap::HAS_ERROR);
                $this->strValidationState = Bootstrap::HAS_ERROR;
            } elseif ($this->strWarning) {
                $this->addWrapperCssClass(Bootstrap::HAS_WARNING);
                $this->strValidationState = Bootstrap::HAS_WARNING;
            } else {
                $this->addWrapperCssClass(Bootstrap::HAS_SUCCESS);
                $this->strValidationState = Bootstrap::HAS_SUCCESS;
            }
        }
        // TODO: Classes that don't use a wrapper
    }

    /**
     * @return boolean
     */
    public function validateControlAndChildren()
    {
        // Initially Assume Validation is True
        $blnToReturn = parent::validateControlAndChildren();
        /*
                // Check the Control Itself
                if (!$blnToReturn) {
                    foreach ($this->getChildControls() as $objChildControl) {
                        $objChildControl->reinforceValidationState();
                    }
                }*/
        $this->reinforceValidationState();
        return $blnToReturn;
    }

    /**
     * The Superclass assumes that we want everything to be inline. We essentially turn this off to allow Bootstrap
     * to do what it wants.
     *
     * @param bool $blnIsBlockElement
     * @return string
     */
    protected function getWrapperStyleAttributes($blnIsBlockElement=false)
    {
        return '';
    }

    // Abstract classes to squash warnings
    abstract public function markAsModified();
    abstract public function addCssClass($strClass);

    /**
     * @return HtmlAttributeManagerBase
     */
    abstract public function getWrapperStyler();

    /**
     * @param $strName
     * @param $mixValue
     * @throws InvalidCast
     */
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case 'ValidationError':
                parent::__set($strName, $mixValue);
                $this->reinforceValidationState();
                break;

            case 'Warning':
                parent::__set($strName, $mixValue);
                $this->reinforceValidationState();
                break;

            case "Display":
                parent::__set($strName, $mixValue);
                if ($this->blnDisplay) {
                    $this->removeWrapperCssClass(Bootstrap::HIDDEN);
                    $this->removeCssClass(Bootstrap::HIDDEN);
                } else {
                    $this->addWrapperCssClass(Bootstrap::HIDDEN);
                    $this->addCssClass(Bootstrap::HIDDEN);
                }
                break;

            case "LabelCssClass":
                $strClass = Type::cast($mixValue, Type::STRING);
                $this->getLabelStyler()->setCssClass($strClass);
                break;

            case "HorizontalClass": // for wrapping a control with a div with this class, mainly for column control on horizontal forms
                $this->strHorizontalClass = Type::cast($mixValue, Type::STRING);
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
}
