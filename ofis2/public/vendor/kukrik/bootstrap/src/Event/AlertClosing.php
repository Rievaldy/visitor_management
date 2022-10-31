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
 * Class AlertClosing
 * Event is fired just before an alert is closed, when the button is clicked.
 *
 * @package QCubed\Bootstrap\Event
 * @was Alert_ClosingEvent
 */
class AlertClosing extends EventBase
{
    /** Event Name */
    const EVENT_NAME = 'close.bs.alert';
}
