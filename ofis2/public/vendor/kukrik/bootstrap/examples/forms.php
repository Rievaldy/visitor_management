<?php
require_once(__DIR__ . '/qcubed.inc.php');

use QCubed\Bootstrap as Bs;
use QCubed\Project\Application;
use QCubed\Project\Control\FormBase as QForm;

/**
 * Normally you would set up your QControl class to inherit from the Bootstrap plugin's Control class. This is
 * an alternate method of doing one-off Boostrap controls. We do that here because for this example, we might not
 * have the ability to alter the QControl class.
 */
class MyTextBox extends Bs\TextBox
{
    protected $strCssClass = Bs\Bootstrap::FORM_CONTROL;
    use Bs\ControlTrait;
}

class MyButton extends Bs\Button
{
    use Bs\ControlTrait;
}


class SampleForm extends QForm
{

    protected $firstName;
    protected $lastName;
    protected $street;
    protected $city;
    protected $state;
    protected $zip;
    protected $button;

    protected function formCreate()
    {
        $this->firstName = new MyTextBox ($this);    // Normally you would use Bs\Textbox here.
        $this->firstName->Name = t('First Name');

        $this->lastName = new MyTextBox ($this);
        $this->lastName->Name = t('Last Name');

        $this->street = new MyTextBox ($this);
        $this->street->Name = t('Street');

        $this->city = new MyTextBox ($this);
        $this->city->Name = t('City');

        $this->state = new MyTextBox ($this);
        $this->state->Name = t('State');

        $this->zip = new MyTextBox ($this);
        $this->zip->Name = t('Postal Code');

        $this->button = new MyButton ($this);    // Normally you would use Bs\Button here.
        $this->button->Text = 'OK';
    }

}

$formName = Application::instance()->context()->queryStringItem('formName');
if (!$formName) {
    $formName = 'forms1';
}

SampleForm::run('SampleForm', $formName . '.tpl.php');
