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
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Type;

/**
 * Class CarouselItem
 *
 * An item to add as a child control to a Carousel
 *
 * @property string $ImageUrl Url of the image to show here
 * @property string $AltText Alt text to show for the image
 * @package QCubed\Bootstrap
 */
class CarouselItem extends HListItem {
    protected $strImageUrl;
    protected $strAltText;

    /**
     * CarouselItem constructor.
     * @param string $strImageUrl
     * @param null|string $strAltText
     * @param null|string $strText
     * @param null|string $strAnchor
     * @param null|string $strId
     */
    public function __construct($strImageUrl, $strAltText, $strText = null, $strAnchor = null, $strId = null) {
        parent::__construct($strText, $strAnchor, $strId);
        $this->strImageUrl = $strImageUrl;
        $this->strAltText = $strAltText;
    }

    /**
     * @param string $strText
     * @return mixed
     * @throws Caller
     */
    public function __get($strText) {
        switch ($strText) {
            case "ImageUrl": return $this->strImageUrl;
            case "AltText": return $this->strAltText;

            default:
                try {
                    return parent::__get($strText);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }

    /**
     * @param string $strText
     * @param string $mixValue
     * @throws Caller
     * @throws InvalidCast
     */
    public function __set($strText, $mixValue) {
        switch ($strText) {
            case "ImageUrl":
                try {
                    $this->strImageUrl = Type::cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case "AltText":
                try {
                    $this->strAltText = Type::cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            default:
                try {
                    parent::__set($strText, $mixValue);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;
        }
    }
}