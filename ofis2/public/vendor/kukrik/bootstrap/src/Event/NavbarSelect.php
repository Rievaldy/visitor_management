<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap\Event;

use QCubed\Event\EventBase;

/**
 * Class NavbarSelect
 *
 * @package QCubed\Bootstrap
 * @was Navbar_SelectEvent
 */
class NavbarSelect extends EventBase {
    const EVENT_NAME = 'bsmenubarselect';
    const JS_RETURN_PARAM = 'ui';
}
