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
 * Class NavSelect
 *
 * same as a tab select
 *
 * @package QCubed\Bootstrap
 */
class NavSelect extends EventBase {
    const EVENT_NAME = 'shown.bs.tab';
    const JS_RETURN_PARAM = 'ui';
}
