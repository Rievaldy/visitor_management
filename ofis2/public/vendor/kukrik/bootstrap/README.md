# QCubed Bootstrap Plugin
QCubed plugin to simplify the integration of Twitter Bootstrap

## Installation
1) Install both the plugin and twitter bootstrap using Composer. Execute the following on the command line from your main
install directory:
```
	composer require qcubed/bootstrap
	composer require twbs/bootstrap
```    
2) Next, you might want to alter some of the settings in the bootstrap.cfg.php file. Look for that
in /project/includes/configuration/active

### QCUBED_BOOTSTRAP_CSS
The default setting for this file is:
```
	define ('QCUBED_BOOTSTRAP_CSS', QCUBED_VENDOR_URL . '/twbs/bootstrap/dist/css/bootstrap.min.css');
```
If you are compiling your own custom version of the bootstrap css file, simply set that define to point to your own version.

3) Point the base class to Bootstrap classes so that they add their functionality.

In your project/qcubed/Control/ControlBase.php file, extend from the Bootstrap Control class. For example,
you should change the first line to:

```
abstract class ControlBase extends QCubed\Bootstrap\Control 
{
```

### QCUBED_BOOTSTRAP_JS
The default mechanism included in this plugin only loads the bootstrap.js file on forms using the plugin widgets that
need it. If you are hand-coding some bootstrap forms that also need bootstrap.js, you should do both of the following to avoid
multiple bootstrap.js files being loaded:

1) Define QCUBED_BOOTSTRAP_JS in your bootstrap.cfg.php file and point it to your desired bootstrap js file as so:
```
	define ('QCUBED_BOOTSTRAP_JS', QCUBED_VENDOR_URL . '/twbs/bootstrap/dist/js/bootstrap.js'); (or bootstrap.min.js if you prefer)
```
2) Either add this file to your footer.inc.php file like this:
```
	<script type="text/javascript" src="<?= QCUBED_BOOTSTRAP_JS ?>"></script>
```
or add it to the list of auto-loaded javascript forms in your QForm.class.php file like this:
```
	protected function getFormJavaScripts() {
		$scripts = parent::getFormJavaScripts();
		$scripts[] = QCUBED_BOOTSTRAP_JS;
		return $scripts;
	}

```

## Usage

See the examples pages for details. The main functionality includes:

1. Using **RenderFormGroup** instead of RenderWithName to draw form objects in the Bootstrap way. The Bootstrap Control
class exposes a number of utility classes to add Bootstrap class to the object, the label, the wrapper, and even
some internal wrappers in special situations.

2. Specific Bootstrap type Controls to draw particular things on the screen. Examples include:
 * Carousel
 * Navbar
 * Menu button
 * Alert
 * Accordion

3. Extensions of base QCubed controls with additional Bootstrap functionality. Includes:
 * Checkbox to draw checkboxes the bootstrap way with the label wrapping the checkbox
 * TextBox to add the ability to draw it as an inline-group with another object

4. Defines that give you easy access to all the various Bootstrap class names via PHP constants. Those are located
in the Bootstrap.php file.
