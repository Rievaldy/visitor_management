<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Bootstrap\Event\ModalHidden;
use QCubed\Control\ControlBase;
use QCubed\Control\FormBase;
use QCubed\Control\Panel;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Project\Application;
use QCubed\Project\Jqui\Dialog;
use QCubed\Action;
use QCubed\Type;
use QCubed as Q;

/**
 * Class Modal
 *
 * The Modal class defined here provides the dialog functionality of bootstrap modals in a way that is accessible
 * from QCubed.
 *
 * The interface is similar to the \QCubed\Project\Jqui\Dialog interface. This is a subclass of \QCubed\Control\Panel, so you can define whatever
 * you want to appear in a \QCubed\Control\Panel, and it will show up in the modal. There are also functions to add buttons at
 * the bottom, a title and close button at the top, and to respond to those clicks.
 *
 * This current implementation uses javascript to wrap the panel in bootstrap friendly html, similar to how
 * jQueryUI works.
 *
 * Currently, bootstrap does not support multiple modals up at once (stacked modals), though this could be done
 * in the javascript.
 *
 * There are a couple of ways to use the dialog. The simplest is as follows:
 *
 * In your formCreate():
 * <code>
 * $this->dlg = new BS\Modal($this);
 * $this->dlg->Text = 'Show this on the dialog.'
 * $this->dlg->addButton('OK', 'ok', false, true, null, ['data-dismiss'='modal']);
 * </code>
 *
 * When you want to show the modal:
 * <code>
 * $this->dlg->showDialogBox();
 * </code>
 *
 * You do not need to draw the dialog. It will automatically be drawn for you.
 *
 * Since Modal is a descendant of \QCubed\Control\Panel, you can do anything you can to a normal \QCubed\Control\Panel,
 * including add Controls and use a template. When you want to hide the dialog, call <code>HideDialogBox()</code>
 *
 * However, do not mark the dialog's wrapper as modified while it is being shown. This will cause redraw problems.
 *
 * @property boolean $AutoOpen Automatically opens the dialog when its drawn.
 * @property boolean $Show Synonym of AutoOpen.
 * @property boolean $HasCloseButton Disables (false) or enables (true) the close X in the upper right corner of the title.
 *    Can be set when initializing the dialog. Also enables or disables the ability to close the box by pressing the ESC key.
 * @property boolean $CloseOnEscape Allows the ESC key to automatically close the dialog with no button click.
 * @property boolean $Keyboard Synonym of CloseOnEscape.
 * @property boolean $Fade Whether to fade in (default), or just make dialog appear instantly.
 * @property string $Title Title to display at the top of the dialog.
 * @property string $Size Bootstrap::ModalLarge or Bootstrap::ModalSmall.
 * @property mixed $Backdrop true to use grayed out backdrop (default), false to not have a backdrop, and the word "static" to have a backdrop and not allow clicking outside of the dialog to dismiss.
 * @property string $HeaderClasses Additional classes to add to the header. Useful for giving a header background, like Bootstrap::BackgroundWarning
 * @property-read integer $ClickedButton Returns the id of the button most recently clicked. (read-only)
 * @property-write string $DialogState Set whether this dialog is in an error or highlight (info) state. Choose on of \QCubed\Project\Jqui\Dialog::STATE_NONE, QDialogState::StateError, QDialogState::stateHighlight(write-only)
 *
 * @link http://getbootstrap.com/javascript/#modals
 * @package QCubed\Bootstrap
 */
class Modal extends Panel
{
    /** @var bool make sure the modal gets rendered */
    protected $blnAutoRender = true;

    /** The control id to use for the reusable global alert dialog. */
    const MESSAGE_DIALOG_ID = 'qAlertDialog';

    /** @var bool default to auto open being false, since this would be a rare need, and dialogs are auto-rendered. */
    protected $blnAutoOpen = false;
    /** @var  string Id of last button clicked. */
    protected $strClickedButtonId;
    /** @var bool Should we draw a close button on the top? */
    protected $blnHasCloseButton = true;
    /** @var bool records whether dialog is open */
    protected $blnIsOpen = false;
    /** @var array whether a button causes validation */
    protected $blnValidationArray = array();

    protected $blnUseWrapper = true;
    /** @var  string state of the dialog for special display */
    protected $strDialogState;
    /** @var  string */
    protected $strHeaderClasses;
    /** @var  bool */
    protected $blnCloseOnEscape;
    /** @var  bool */
    protected $blnFade;
    /** @var  string */
    protected $strTitle;
    /** @var  array */
    protected $mixButtons;
    /** @var  Bootstrap::ModalLarge or ModalSmall */
    protected $strSize;
    /** @var  bool|string true or false whether to have an overlay backdrop, or the string "static", which means have a backdrop, and don't close when clicking outside of dialog. */
    protected $mixBackdrop;

    /**
     * Modal constructor
     *
     * @param ControlBase|FormBase|null $objParentObject
     * @param null|string $strControlId
     */
    public function __construct($objParentObject = null, $strControlId = null)
    {

        // Detect which mode we are going to display in, whether to show right away, or wait for later.
        if ($objParentObject === null) {
            // The dialog will be shown right away, and then when closed, removed from the form.
            global $_FORM;
            $objParentObject = $_FORM;    // The parent object should be the form. Prevents spurious redrawing.
            $this->blnDisplay = true;
            $this->blnAutoOpen = true;
            $blnAutoRemove = true;
        } else {
            $blnAutoRemove = false;
            $this->blnDisplay = false;
        }

        parent::__construct($objParentObject, $strControlId);
        $this->mixCausesValidation = $this;
        Bootstrap::loadJS($this);
        $this->addCssFile(QCUBED_BOOTSTRAP_CSS);
        $this->addJavascriptFile(QCUBED_BOOTSTRAP_ASSETS_URL . '/js/qc.bs.modal.js');

        /* Setup wrapper to prevent flash drawing of unstyled dialog. */
        $objWrapperStyler = $this->getWrapperStyler();
        $objWrapperStyler->addCssClass('modal fade');
        $objWrapperStyler->setHtmlAttribute('tabIndex', -1);
        $objWrapperStyler->setHtmlAttribute('role', 'dialog');

        if ($blnAutoRemove) {
            // We need to immediately detect a close so we can remove it from the form
            // Delay in an attempt to make sure this is the very last thing processed for the dialog.
            // If you want to do something just before closing, trap the AlertClosing event
            $this->addAction(new Event\AlertClosed(10), new Q\Action\AjaxControl($this, 'alert_Close'));
        }
    }

    /**
     * Validate the child items if the dialog is visible and the clicked button requires validation.
     * This piece of magic makes validation specific to the dialog if an action is coming from the dialog,
     * and prevents the controls in the dialog from being validated if the action is coming from outside
     * the dialog.
     *
     * @return bool
     */
    public function validateControlAndChildren()
    {
        if ($this->blnIsOpen) {    // don't validate a closed dialog
            if (!empty($this->mixButtons)) {    // using built-in dialog buttons
                if (!empty ($this->blnValidationArray[$this->strClickedButtonId])) {
                    return parent::validateControlAndChildren();
                }
            } else {    // using QButtons placed in the control
                return parent::validateControlAndChildren();
            }
        }
        return true;
    }

    /**
     * @return string
     */
    protected function getJqSetupFunction()
    {
        return 'bsModal';
    }

    /**
     * Returns the control id for purposes of attaching events.
     * @return string
     */
    public function getJqControlId()
    {
        return $this->ControlId . '_ctl';
    }

    /**
     * Overrides the parent to call the qc.bs.modal js initializer.
     */

    protected function makeJqWidget()
    {
        Application::executeControlCommand($this->getJqControlId(), "off", Application::PRIORITY_HIGH);
        $jqOptions = $this->makeJqOptions();
        Application::executeControlCommand($this->ControlId, $this->getJqSetupFunction(), $jqOptions,
            Application::PRIORITY_HIGH);
    }

    /**
     * Returns an array of options that get set to the setup function as javascript.
     * @return null
     */
    protected function makeJqOptions()
    {
        $jqOptions = null;
        if (!is_null($val = $this->AutoOpen)) {
            $jqOptions['show'] = $val;
        }
        if (!is_null($val = $this->CloseOnEscape)) {
            $jqOptions['keyboard'] = $val;
        }
        if (!is_null($val = $this->Backdrop)) {
            $jqOptions['backdrop'] = $val;
        }
        if (!is_null($val = $this->Fade)) {
            $jqOptions['fade'] = $val;
        }
        if (!is_null($val = $this->Title)) {
            $jqOptions['title'] = $val;
        }
        if (!is_null($val = $this->Size)) {
            $jqOptions['size'] = $val;
        }

        if (!is_null($this->mixButtons)) {
            $jqOptions['buttons'] = $this->mixButtons;
        }

        switch ($this->strDialogState) {
            case Dialog::STATE_ERROR:
                $strHeaderClasses = Bootstrap::BACKGROUND_DANGER;
                break;

            case Dialog::STATE_HIGHLIGHT:
                $strHeaderClasses = Bootstrap::BACKGROUND_WARNING;
                break;

            default:
                if ($this->strHeaderClasses) {
                    $strHeaderClasses = $this->strHeaderClasses;
                } else {
                    $strHeaderClasses = Bootstrap::BACKGROUND_PRIMARY;
                }
        }

        $jqOptions['headerClasses'] = $strHeaderClasses;

        return $jqOptions;
    }


    /**
     * Adds a button to the dialog. Use this to add buttons BEFORE bringing up the dialog.
     *
     * @param string $strButtonName Text to use on the button.
     * @param string $strButtonId Id associated with the button for detecting clicks. Note that this is not the id of the button on the form.
     *                                    Different dialogs can have the same button id.
     *                                    To specify a control id for the button (for styling purposes for example), set the id in options.
     * @param bool $blnCausesValidation If the button causes the dialog to be validated before the action is executed
     * @param bool $blnIsPrimary Whether this button will be automatically clicked if user presses an enter key.
     * @param string $strConfirmation If set, will confirm with the given string before the click is sent
     * @param array $attr Additional attributes to add to the button tag. Will override all other attributes in the button.
     *                                      Useful to do is button style, like ['class'=>'btn-primary']. Also useful is to automatically close
     *                                      the dialog with ['data-dismiss'='modal']
     */
    public function addButton(
        $strButtonName,
        $strButtonId = null,
        $blnCausesValidation = false,
        $blnIsPrimary = false,
        $strConfirmation = null,
        $attr = null
    ) {
        if (!$this->mixButtons) {
            $this->mixButtons = [];
        }
        $btnOptions = [];
        if ($strConfirmation) {
            $btnOptions['confirm'] = $strConfirmation;
        }

        if (!$strButtonId) {
            $strButtonId = $strButtonName;
        }

        $btnOptions['id'] = $strButtonId;
        $btnOptions['text'] = $strButtonName;

        if ($attr) {
            $btnOptions['attr'] = $attr;
        }

        if ($blnIsPrimary) {
            $btnOptions['isPrimary'] = true;

            // Match the primary button style to the header style for a more pleasing effect. This can be overridden with the 'attr' option above.
            switch ($this->strDialogState) {
                case Dialog::STATE_ERROR:
                    $btnOptions['style'] = 'danger';
                    break;

                case Dialog::STATE_HIGHLIGHT:
                    $btnOptions['style'] = 'warning';
                    break;

                default:
                    $btnOptions['style'] = 'primary';
                    break;
            }
        }

        $this->mixButtons[] = $btnOptions;
        $this->blnValidationArray[$strButtonId] = $blnCausesValidation;
        $this->blnModified = true;
    }

    /**
     * Remove the given button from the dialog.
     *
     * @param $strButtonId
     */
    public function removeButton($strButtonId)
    {
        if (!empty($this->mixButtons)) {
            $this->mixButtons = array_filter($this->mixButtons, function ($a) use ($strButtonId) {
                return $a['id'] == $strButtonId;
            });
        }

        unset ($this->blnValidationArray[$strButtonId]);

        $this->blnModified = true;
    }

    /**
     * Remove all the buttons from the dialog.
     */
    public function removeAllButtons()
    {
        $this->mixButtons = array();
        $this->blnValidationArray = array();
        $this->blnModified = true;
    }

    /**
     * Show or hide the given button. Changes the display attribute, so the buttons will reflow.
     *
     * @param $strButtonId
     * @param $blnVisible
     */
    public function showHideButton($strButtonId, $blnVisible)
    {
        Application::executeControlCommand($this->ControlId, $this->getJqSetupFunction(), 'showButton', $strButtonId,
            $blnVisible);
    }

    /**
     * Applies CSS styles to a button that is already in the dialog.
     *
     * @param string $strButtonId Id of button to set the style on
     * @param array $styles Array of key/value style specifications
     */
    public function setButtonStyle($strButtonId, $styles)
    {
        Application::executeControlCommand($this->ControlId, $this->getJqSetupFunction(), 'setButtonCss', $strButtonId,
            $styles);
    }

    /**
     * Adds a close button that closes the dialog when clicked. Does not record the fact that it was clicked.
     *
     * @param $strButtonName
     */
    public function addCloseButton($strButtonName)
    {
        $this->mixButtons[] = [
            'id' => $strButtonName,
            'text' => $strButtonName,
            'close' => true,
            'click' => false
        ];
        $this->blnModified = true;
    }

    /**
     * Create a message dialog. Automatically adds an OK button that closes the dialog. To detect the close,
     * add an action on the Modal_HiddenEvent. To change the message, use the return value and set ->Text.
     * To detect a button click, add a \QCubed\Event\DialogButton.
     *
     * If you specify no buttons, a close box in the corner will be created that will just close the dialog. If you
     * specify just a string in $mixButtons, or just one string in the button array, one button will be shown that will just close the message.
     *
     * If you specify more than one button, the first button will be the default button (the one pressed if the user presses the return key). In
     * this case, you will need to detect the button by adding a \QCubed\Event\DialogButton. You will also be responsible for calling "Close()" on
     * the dialog after detecting a button.
     *
     * @param string $strMessage // The message
     * @param string|string[]|null $strButtons
     * @param string|null $strControlId
     * @return Modal
     */
    public static function alert($strMessage, $strButtons = null, $strControlId = null)
    {
        global $_FORM;

        $objForm = $_FORM;
        $dlg = new Modal($objForm, $strControlId);
        //$dlg->markAsModified(); // Make sure it gets drawn.
        $dlg->Text = $strMessage;
        $dlg->addAction(new ModalHidden(), new Action\AjaxControl($dlg, 'Alert_Close'));
        if ($strButtons) {
            $dlg->blnHasCloseButton = false;
            if (is_string($strButtons)) {
                $dlg->addCloseButton($strButtons);
            } elseif (count($strButtons) == 1) {
                $dlg->addCloseButton($strButtons[0]);
            } else {
                $strButton = array_shift($strButtons);
                $dlg->addButton($strButton, null, false, true);    // primary button

                foreach ($strButtons as $strButton) {
                    $dlg->addButton($strButton);
                }
            }
        } else {
            $dlg->blnHasCloseButton = true;
        }
        $dlg->showDialogBox();
        return $dlg;
    }

    /**
     * An alert is closing, so we remove the dialog from the dom.
     *
     */
    public function alert_Close()
    {
        $this->Form->removeControl($this->ControlId);
    }

    /**
     * Show the dialog. Implements the dialog interface.
     **/
    public function showDialogBox()
    {
        $this->Visible = true; // will redraw the control if needed
        $this->Display = true; // will update the wrapper if needed
        $this->open();
        //$this->blnWrapperModified = false;
    }

    /**
     * Hide the dialog
     */
    public function hideDialogBox()
    {
        $this->close();
    }

    /**
     * Show the dialog. Only works if dialog is already on the page in a hidden state.
     */
    public function open()
    {
        Application::executeControlCommand($this->ControlId, $this->getJqSetupFunction(), 'open',
            Application::PRIORITY_LOW);
    }

    /**
     * Hide the dialog
     */
    public function close()
    {
        Application::executeControlCommand($this->ControlId, $this->getJqSetupFunction(), 'close',
            Application::PRIORITY_LOW);
    }

    /**
     * Override to prevent validation state on the dialog itself.
     */
    public function reinforceValidationState()
    {
        // do nothing at the dialog level
    }

    /**
     * Override to prevent the entire dialog from being redrawn while it is open. It can't do that. Mark
     * individual items as modified instead.
     */
    public function markAsWrapperModified()
    {
        if ($this->blnIsOpen) {
            // do nothing

        } else {
            parent::markAsWrapperModified();
        }
    }

    /**
     * PHP magic method
     *
     * @param string $strName
     * @param string $mixValue
     *
     * @throws \Exception|Caller|InvalidCast
     */
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case '_ClickedButton': // Internal only. Do not use. Used by JS above to keep track of clicked button.
                try {
                    $this->strClickedButtonId = Type::cast($mixValue, Type::STRING);
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            case '_IsOpen': // Internal only, to detect when dialog has been opened or closed.
                try {
                    $this->blnIsOpen = Type::cast($mixValue, Type::BOOLEAN);

                    // Setup wrapper style in case dialog is redrawn while it is open.
                    if (!$this->blnIsOpen) {
                        // dialog is closing, so reset all validation states.
                        $this->Form->resetValidationStates();
                    }
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            // These options are specific to bootstrap's modal, but if there is a similar option in \QCubed\Project\Jqui\Dialog, we allow that also.

            case 'AutoOpen':    // the JQueryUI name of this option
            case 'Show':    // the Bootstrap name of this option
                try {
                    $this->blnAutoOpen = Type::cast($mixValue, Type::BOOLEAN);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'HasCloseButton':
                try {
                    $this->blnHasCloseButton = Type::cast($mixValue, Type::BOOLEAN);
                    $this->blnCloseOnEscape = $this->blnHasCloseButton;
                    $this->blnModified = true;    // redraw
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'CloseOnEscape' :    // JQuery UI version
            case 'Keyboard' :        // Bootstrap version
                try {
                    $this->blnCloseOnEscape = Type::cast($mixValue, Type::BOOLEAN);
                    $this->blnModified = true;    // redraw
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Fade' :
                try {
                    $this->blnFade = Type::cast($mixValue, Type::BOOLEAN);
                    if ($this->blnFade) {
                        $this->getWrapperStyler()->addCssClass('fade');
                    } else {
                        $this->getWrapperStyler()->removeCssClass('fade');
                    }
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Title' :
                try {
                    $this->strTitle = Type::cast($mixValue, Type::STRING);
                    $this->blnModified = true;    // redraw
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Size' :
                try {
                    $this->strSize = Type::cast($mixValue, Type::STRING);
                    $this->blnModified = true;    // redraw
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Backdrop' :
                try {
                    if ($mixValue === 'static') {
                        $this->mixBackdrop = 'static';
                    } else {
                        $this->mixBackdrop = Type::cast($mixValue, Type::BOOLEAN);
                    }
                    $this->blnModified = true;    // redraw
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'HeaderClasses' :
                try {
                    $this->strHeaderClasses = Type::cast($mixValue, Type::STRING);
                    $this->blnModified = true;    // redraw
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }


            // These options are part of the \QCubed\Project\Jqui\Dialog interface

            case 'DialogState':
                try {
                    $this->strDialogState = Type::cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Modal':
                // stub, does nothing
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

    /**
     * PHP magic method
     *
     * @param string $strName
     *
     * @return mixed
     * @throws \Exception|Caller
     */
    public function __get($strName)
    {
        switch ($strName) {
            case 'ClickedButton':
                return $this->strClickedButtonId;
            case 'HasCloseButton' :
                return $this->blnHasCloseButton;
            case 'AutoOpen':
            case 'Show' :
                return $this->blnAutoOpen;
            case "CloseOnEscape":
                return $this->blnCloseOnEscape;
            case "HeaderClasses":
                return $this->strHeaderClasses;
            case "Backdrop":
                return $this->mixBackdrop;
            case "Fade":
                return $this->blnFade;
            case "Title":
                return $this->strTitle;
            case "Size":
                return $this->strSize;

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

?>