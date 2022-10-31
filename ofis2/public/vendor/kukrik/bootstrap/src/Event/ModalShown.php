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
 * Class ModalShown
 *
 * Captures the modal shown event, which happens after a modal is shown.
 * Param will be the id of the button that was clicked to show the triangle, if that
 * button was tied to the dialog using a data-toggle="modal" attribute.
 *
 * @package QCubed\Bootstrap\Event
 * @was Modal_ShownEvent
 */
class ModalShown extends EventBase
{
    /** Event Name */
    const EVENT_NAME = 'shown.bs.modal';
    const JS_RETURN_PARAM = 'event.relatedTarget.id';
}
