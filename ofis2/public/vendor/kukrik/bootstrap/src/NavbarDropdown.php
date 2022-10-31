<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\ListItemStyle;
use QCubed\QString;

class NavbarDropdown extends NavbarItem
{
    /**
     * NavbarDropdown constructor.
     * @param string $strName
     */
    public function __construct($strName)
    {
        parent::__construct($strName);
        $this->objItemStyle = new ListItemStyle();
        $this->objItemStyle->setCssClass('dropdown');
    }

    /**
     * @return string
     */
    public function getItemText()
    {
        $strHtml = QString::htmlEntities($this->strName);
        $strHtml = sprintf('<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">%s <span class="caret"></span></a>', $strHtml)  . "\n";
        return $strHtml;
    }

    /**
     * Return the attributes for the sub tag that wraps the item tags
     * @return null|array
     */
    public function getSubTagAttributes()
    {
        return ['class'=>'dropdown-menu', 'role'=>'menu'];
    }
}
