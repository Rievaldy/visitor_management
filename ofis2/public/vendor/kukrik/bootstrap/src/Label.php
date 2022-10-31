<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

/**
 * Class Label
 *
 * Converts a \QCubed\Control\Label to be drawn as a bootstrap "Static Control".
 * @package QCubed\Bootstrap
 */
class Label extends \QCubed\Control\Label
{
    protected $strCssClass = "form-control-static";
    protected $strTagName = "p";
}
