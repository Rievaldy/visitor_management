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
 * Class ModalHide
 *
 * Captures the modal hide event, which happens before the dialog is hidden.
 *
 * @package QCubed\Bootstrap\Event
 * @was Modal_HideEvent
 */
class ModalHide extends EventBase
{
    /** Event Name */
    const EVENT_NAME = 'hide.bs.modal';
}
