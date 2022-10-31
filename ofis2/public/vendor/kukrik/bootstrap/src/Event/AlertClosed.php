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
 * Event is fired just after an alert is closed, after the button is clicked.
 *
 * @package QCubed\Bootstrap\Event
 * @was Alert_ClosingEvent
 */
class AlertClosed extends EventBase
{
    /** Event Name */
    const EVENT_NAME = 'closed.bs.alert';
}
