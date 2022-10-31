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
 * Class InlineForm
 *
 * A wrapper class for objects that will be displayed using the RenderFormGroup method, and that will be drawn using
 * the "form-inline" class for special styling.
 *
 * You should set the PreferredRenderMethod attribute for each of the objects you add.
 *
 * Also, for objects that will be drawn with labels, use the "sr-only" class to hide the labels so that they are
 * available for screen readers.
 *
 * @package QCubed\Bootstrap
 */
class InlineForm extends Panel
{
    protected $strCssClass = "form-inline";
    protected $blnAutoRenderChildren = true;
}
