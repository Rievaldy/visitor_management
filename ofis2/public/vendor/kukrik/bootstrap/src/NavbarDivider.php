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

/**
 * Class NavbarDivider
 * @package QCubed\Bootstrap
 */
class NavbarDivider extends NavbarItem
{
    protected $strAnchor = ''; // No anchor

    public function __construct()
    {
        parent::__construct('');
        $this->objItemStyle = new ListItemStyle();
        $this->objItemStyle->setCssClass('divider');
    }
}
