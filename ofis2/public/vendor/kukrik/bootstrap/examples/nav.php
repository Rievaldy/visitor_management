<?php

require_once(__DIR__ . '/qcubed.inc.php');

use QCubed\Bootstrap as Bs;
use QCubed\Project\Control\FormBase as QForm;

class SampleForm extends QForm
{
    protected $nav1;
    protected $nav2;

    protected function formCreate()
    {
        $this->nav1 = new Bs\Nav($this);
        $objPanel = new \QCubed\Control\Panel($this->nav1);
        $objPanel->Name = 'Tab 1';
        $objPanel->Text = "This is the content of Tab 1";
        $objPanel = new \QCubed\Control\Panel($this->nav1);
        $objPanel->Name = 'Tab 2';
        $objPanel->Text = "And an example of content of Tab 2";
        $objPanel = new \QCubed\Control\Panel($this->nav1);
        $objPanel->Name = 'Tab 3';
        $objPanel->Text = "And an additional example of content of Tab 3";

        $this->nav2 = new Bs\Nav($this);
        $this->nav2->ButtonStyle = Bs\Bootstrap::NAV_PILLS;
        $objPanel = new \QCubed\Control\Panel($this->nav2);
        $objPanel->Name = 'Tab 3';
        $objPanel->Text = "This is the content of Tab 3";
        $objPanel = new \QCubed\Control\Panel($this->nav2);
        $objPanel->Name = 'Tab 4';
        $objPanel->Text = "And an example of content of Tab 4";
    }
}

SampleForm::run('SampleForm');
