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
 * Class ModalHidden
 *
 * Captures the modal hidden event, which happens after the dialog is hidden.
 *
 * @package QCubed\Bootstrap\Event
 * @was Modal_HiddenEvent
 */
class ModalHidden extends EventBase
{
    /** Event Name */
    const EVENT_NAME = 'hidden.bs.modal';
}
