<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Project\Control\Button;

/**
 * Class MenuButton
 * A button that looks like a menu toggle button for bootstrap. Match this with the \QCubed\Action\ToggleCssClass action
 * to turn particular classes on and off. Great for creating custom menus.
 * @package QCubed\Bootstrap
 */
class MenuButton extends Button
{
    protected $strText =    '<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>';

    protected $blnPrimaryButton = false;

    protected $strCssClass = 'navbar-toggle';
}
