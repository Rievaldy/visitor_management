<?php

require_once(__DIR__ . '/qcubed.inc.php');

use QCubed\Bootstrap as Bs;
use QCubed\Project\Control\FormBase as QForm;

class SampleForm extends QForm
{
    protected $lg;
    protected $lblClicked;
    protected $pager;

    protected function formCreate()
    {
        $this->lg = new Bs\ListGroup($this);
        $this->lg->setDataBinder("lg_Bind");
        $this->lg->setItemParamsCallback([$this, "lg_Params"]);
        $this->lg->addClickAction(new \QCubed\Action\Ajax("lg_Action"));
        $this->lg->SaveState = true;

        $this->lblClicked = new \QCubed\Control\Label($this);
        $this->lblClicked->Name = "Clicked on: ";

        $this->pager = new Bs\Pager($this);
        $this->pager->ItemsPerPage = 5;
        $this->lg->Paginator = $this->pager;
    }

    protected function lg_Bind()
    {
        $this->lg->TotalItemCount = Person::countAll();
        $clauses[] = $this->lg->LimitClause;
        $this->lg->DataSource = Person::loadAll($clauses);
    }

    public function lg_Params(Person $objPerson)
    {
        $a['id'] = 'lg_' . $objPerson->Id;
        $a['html'] = \QCubed\QString::htmlEntities($objPerson->FirstName . ' ' . $objPerson->LastName);
        return $a;
    }

    protected function lg_Action($strFormId, $strControlId, $strActionParam)
    {
        $id = substr($strActionParam, 3);
        $objPerson = Person::load($id);
        $this->lblClicked->Text = $objPerson->FirstName . ' ' . $objPerson->LastName;
    }
}

SampleForm::run('SampleForm');
