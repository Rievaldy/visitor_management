<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\HListItem;
use QCubed\Html;
use QCubed\QString;

/**
 * Class NavbarItem
 * An item to add to the navbar list.
 * @package QCubed\Bootstrap
 */
class NavbarItem extends HListItem
{
    /**
     * NavbarItem constructor.
     * @param string $strText
     * @param string|null $strValue
     * @param string|null $strAnchor
     */
    public function __construct($strText = '', $strValue = null, $strAnchor = null)
    {
        parent::__construct($strText, $strValue);
        if ($strAnchor) {
            $this->strAnchor = $strAnchor;
        } else {
            $this->strAnchor = '#'; // need a default for attaching clicks and correct styling.
        }
    }

    /**
     * @return string
     */
    public function getItemText()
    {
        $strHtml = QString::htmlEntities($this->strName);

        if ($strAnchor = $this->strAnchor) {
            $strHtml = Html::renderTag('a', ['href' => $strAnchor], $strHtml, false, true);
        }
        return $strHtml;
    }

    /**
     * @return null
     */
    public function getSubTagAttributes()
    {
        return null;
    }
}
