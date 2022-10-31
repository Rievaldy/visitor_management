<?php

require_once(__DIR__ . '/qcubed.inc.php');

use QCubed\Bootstrap as Bs;
use QCubed\Project\Control\FormBase as QForm;

class SampleForm extends QForm
{
    /** @var  Bs\Modal */
    protected $modal1;
    /** @var Bs\ Button */
    protected $btn1;

    protected $modal2;
    protected $btn2;

    protected function formCreate()
    {
        $this->btn1 = new Bs\Button($this);
        $this->btn1->addAction(new \QCubed\Event\Click(), new \QCubed\Action\Ajax('showDialog'));
        $this->btn1->ActionParameter = 1;
        $this->btn1->Text = "Show Modal 1";

        $this->modal1 = new Bs\Modal($this);
        $this->modal1->Text = "Hi there";
        $this->modal1->Title = "Simple Modal";

        $this->btn2 = new Bs\Button($this);
        $this->btn2->addAction(new \QCubed\Event\Click(), new \QCubed\Action\Ajax('showDialog'));
        $this->btn2->ActionParameter = 2;
        $this->btn2->Text = "Show Modal 2";

        $this->modal2 = new Bs\Modal($this);
        $this->modal2->Text = "Hi there";
        $this->modal2->Title = "Modal with Buttons";
        $this->modal2->addButton('Watch Out', 'wo', false, false, "Are you sure?",
            ['class' => Bs\Bootstrap::BUTTON_WARNING]);
        $this->modal2->addCloseButton('Cancel');
        $this->modal2->addButton('OK', 'ok', false, true);
        $this->modal2->addAction(new \QCubed\Event\DialogButton(), new \QCubed\Action\Ajax('buttonClick2'));
    }

    public function showDialog($strFormId, $strControlId, $strActionParam)
    {
        $strControlName = 'modal' . $strActionParam;
        $this->$strControlName->showDialogBox();
    }

    public function buttonClick2($strFormId, $strControlId, $strParameter)
    {
        $this->modal2->hideDialogBox();
        Bs\Modal::alert("Button '" . $strParameter . "' was clicked");
    }
}

SampleForm::run('SampleForm');
