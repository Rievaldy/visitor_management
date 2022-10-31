<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Bootstrap;

use QCubed\Control\ControlBase;
use QCubed\Control\FormBase;
use QCubed\Control\HList;
use QCubed\Html;
use QCubed\Project\Application;
use QCubed\Js;

/**
 * Class Carousel
 * A control that implements a Bootstrap Carousel
 *
 * Use the BsCarousel_SelectEvent to detect a click on an item in the carousel.
 *
 * Note: Keeping track of which carousel item is showing is not currently implemented, mainly because it creates
 * unnecessary traffic between the browser and server, and not sure there is any compelling reason. Also, a redraw of
 * the control will reset the carousel to the first item as active.
 */
class Carousel extends HList {
	protected $strCssClass = 'carousel slide';

    /**
     * Carousel constructor.
     * @param ControlBase|FormBase $objParent
     * @param null $strControlId
     */
	public function __construct ($objParent, $strControlId = null) {
		parent::__construct ($objParent, $strControlId);

		//$this->addCssFile(__BOOTSTRAP_CSS__);
	}

    /**
     * @return bool
     */
	public function validate() {return true;}

    /**
     *
     */
	public function parsePostData() {}

    /**
     * @return string
     * @throws \Exception
     */
	protected function getItemsHtml() {
		$strHtml = '';
		$active = ' active';	// make first one active

		foreach ($this->getAllItems() as $objItem) {
		    if (!($objItem instanceof CarouselItem)) {
		        throw new \Exception('Carousel child controls must be CarouselItems');
            }
            else {
                $strImg = Html::renderTag('img', ['class'=>'img-responsive center-block', 'src'=>$objItem->ImageUrl, 'alt'=>$objItem->AltText], null, true);
                if ($objItem->Anchor) {
                    $strImg = Html::renderTag('a', ['href'=>$objItem->Anchor], $strImg);
                }
                $strImg .= Html::renderTag('div', ['class'=>'carousel-caption'], $objItem->Text);

                $strHtml .= Html::renderTag('div', ['class'=>'item ' . $active, 'id'=>$objItem->Id], $strImg);
                $active = '';	// subsequent ones are inactive on initial drawing
            }
		}
		return $strHtml;
	}

    /**
     * @return string
     */
	protected function getIndicatorsHtml() {
		$strToReturn = '';
		for ($intIndex = 0; $intIndex < $this->getItemCount(); $intIndex++) {
			if ($intIndex == 0) {
				$strToReturn .= Html::renderTag('li', ['data-target'=>'#' . $this->strControlId, 'data-slide-to'=>$intIndex, 'class'=>"active"]);
			} else {
				$strToReturn .= Html::renderTag('li', ['data-target'=>'#' . $this->strControlId, 'data-slide-to'=>$intIndex]);
			}
		}
		return $strToReturn;
	}

    /**
     * @return string
     */
	public function getControlHtml() {
		$strIndicators = $this->getIndicatorsHtml();
		$strItems = $this->getItemsHtml();

		$strHtml = <<<TMPL
<ol class="carousel-indicators">
$strIndicators
</ol>
<div class="carousel-inner" role="listbox">
$strItems
</div>

<a class="left carousel-control" href="#{$this->strControlId}" role="button" data-slide="prev">
	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	<span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#{$this->strControlId}" role="button" data-slide="next">
	<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	<span class="sr-only">Next</span>
</a>

TMPL;

		return $this->renderTag('div', ['data-ride'=>'carousel'], null, $strHtml);
	}

	public function makeJqWidget() {
		Application::executeControlCommand($this->ControlId, 'on', 'click', '.item',
			new Js\Closure("jQuery(this).trigger('bscarousselect', this.id)"), Application::PRIORITY_HIGH);
	}

}


