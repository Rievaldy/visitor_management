<?php

/**
 * Called by the ModelConnector Designer to create a list of controls appropriate for the given database field type.
 * The control will  be available in the list of controls that appear in ModelConnector desginer dialog
 * in the ControlClass entry.
 */
use QCubed\ModelConnector\ControlType;

$controls[ControlType::TEXT][] = 'QCubed\\Bootstrap\\TextBox';

return $controls;