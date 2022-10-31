<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\HList;

/**
 * Basic Navbar list for inserting into the navbar
 */

class NavbarList extends HList
{
    protected $strCssClass = 'nav navbar-nav';

    public function addMenuItem(NavbarItem $objMenuItem)
    {
        parent::addItem($objMenuItem);
    }

    /**
     * Return the text html of the item.
     *
     * @param mixed $objItem
     * @return string
     */
    protected function getItemText($objItem)
    {
        return $objItem->getItemText();    // redirect to subclasses of item
    }

    /**
     * Return the attributes for the sub tag that wraps the item tags
     * @param mixed $objItem
     * @return array|null|string
     */
    public function getSubTagAttributes($objItem)
    {
        return $objItem->getSubTagAttributes();
    }
}
