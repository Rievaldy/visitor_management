<?php
require_once(__DIR__ . '/qcubed.inc.php');

use QCubed\Bootstrap as Bs;
use QCubed\Control\RadioButtonList;
use QCubed\Html;
use QCubed\Project\Control\FormBase as QForm;
use QCubed\QString;

class SampleForm extends QForm
{
    protected $navBar;
    protected $carousel;
    /** @var  Bs\Accordion */
    protected $accordion;

    protected $lstRadio1;
    protected $lstRadio2;

    protected $lstPlain;

    protected function formCreate()
    {
        $this->navBar_Create();
        $this->carousel_Create();
        $this->accordion_Create();
        $this->radioList_Create();
        $this->dropdowns_Create();
    }

    protected function navBar_Create()
    {
        $this->navBar = new Bs\Navbar($this, 'navbar');

        //$this->objMenu->addCssClass('navbar-ryaa');
        $url = QCUBED_APP_TOOLS_URL . '/start_page.php';
        $this->navBar->HeaderText = Html::renderTag("img",
            ["class" => "logo", "src" => QCUBED_IMAGE_URL . "/qcubed_logo_footer.png", "alt" => "Logo"], null, true);
        $this->navBar->HeaderAnchor = $url;
        $this->navBar->StyleClass = Bs\Bootstrap::NAVBAR_INVERSE;

        $objList = new Bs\NavbarList($this->navBar);
        $objListMenu = new Bs\NavbarDropdown('List');
        $objEditMenu = new Bs\NavbarDropdown('New');

        // Add all the lists and edits in the drafts directory
        $list = scandir(QCUBED_FORMS_DIR);
        foreach ($list as $name) {
            if ($offset = strpos($name, '_list.php')) {
                $objListMenu->addItem(new Bs\NavbarItem(substr($name, 0, $offset), null,
                    QCUBED_FORMS_URL . '/' . $name));
            } elseif ($offset = strpos($name, '_edit.php')) {
                $objEditMenu->addItem(new Bs\NavbarItem(substr($name, 0, $offset), null,
                    QCUBED_FORMS_URL . '/' . $name));
            }
        }

        $objList->addMenuItem($objListMenu);;
        $objList->addMenuItem($objEditMenu);

        /*

        $objRandomMenu = new Bs\NavbarDropdown('Contribute');

        $objList->addMenuItem(new Bs\NavbarItem("Login", __SUBDIRECTORY__ . '/private/login.html', 'navbarLogin'));
        */

    }

    protected function carousel_Create()
    {
        $this->carousel = new Bs\Carousel ($this);
        $this->carousel->addListItem(new Bs\CarouselItem('cat.jpg', 'Cat'));
        $this->carousel->addListItem(new Bs\CarouselItem('rhino.jpg', 'Rhino'));
        $this->carousel->addListItem(new Bs\CarouselItem('pig.jpg', 'Pig'));
    }

    protected function accordion_Create()
    {
        $this->accordion = new Bs\Accordion($this);
        $this->accordion->setDataBinder("Accordion_Bind");
        $this->accordion->setDrawingCallback([$this, "Accordion_Draw"]);
    }

    protected function accordion_Bind()
    {
        $this->accordion->DataSource = Person::loadAll([\QCubed\Query\QQ::expand(QQN::person()->Address)]);
    }

    public function accordion_Draw($objAccordion, $strPart, $objItem, $intIndex)
    {
        switch ($strPart) {
            case Bs\Accordion::RENDER_HEADER:
                $objAccordion->renderToggleHelper(QString::htmlEntities($objItem->FirstName . ' ' . $objItem->LastName));
                break;

            case Bs\Accordion::RENDER_BODY:
                if ($objItem->Address) {
                    echo "<b>Address: </b>" . $objItem->Address->Street . ", " . $objItem->Address->City . "<br />";
                }
                break;
        }
    }

    protected function radioList_Create()
    {
        $this->lstRadio1 = new Bs\RadioList($this);
        $this->lstRadio1->addItems(["yes" => "Yes", "no" => "No"]);

        $this->lstRadio2 = new Bs\RadioList($this);
        $this->lstRadio2->addItems(["yes" => "Yes", "no" => "No"]);
        $this->lstRadio2->ButtonMode = RadioButtonList::BUTTON_MODE_SET;
        $this->lstRadio2->ButtonStyle = Bs\Bootstrap::BUTTON_PRIMARY;

    }

    protected function dropdowns_Create()
    {
        $selItems = [
            new Bs\DropdownItem("First"),
            new Bs\DropdownItem("Second"),
            new Bs\DropdownItem("Third")

        ];
        $this->lstPlain = new Bs\Dropdown($this);
        $this->lstPlain->Text = "Plain";
        $this->lstPlain->addItems($selItems);
    }


}

SampleForm::run('SampleForm');
