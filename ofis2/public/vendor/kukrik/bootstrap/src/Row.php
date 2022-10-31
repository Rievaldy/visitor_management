<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\Panel;

/**
 * Class Row
 *
 * A Bootstrap Row panel.
 *
 * You should set the PreferredRenderMethod attribute for each of the objects you add, if needed.
 *
 * Bootstrap's grid is designed to mostly want just column divs on the level below the row div, and not to mix them
 * with other classes. To create column divs, just insert QPanels, and set the class to the column spec needed.
 *
 * @package QCubed\Bootstrap
 */
class Row extends Panel
{
    protected $strCssClass = "row";
    protected $blnAutoRenderChildren = true;
}
