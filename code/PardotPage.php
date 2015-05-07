<?php
/**
 *
 * @package SilverStripe-Pardot
 * @subpackage SilverStripe-Pardot
 */

class PardotPage extends Controller {
	/**
	 * This function starts the routine, and is the first function
	 * to execute off the URL accessor (defined in @see _config.php)
	 */

	public function index() {
		$pardot = new Pardot_API(PardotConfig::getPardotCredentials());
		$forms_object = $pardot->get_forms(PardotConfig::getPardotCredentials());
		$forms = array();
		foreach($forms_object as $form_object)
		{
			$forms[]['name'] = $form_object->name;
		}
		$forms = new ArrayList($forms);

		$content_object = $pardot->get_dynamicContent(PardotConfig::getPardotCredentials());
		$contents = array();
		foreach($content_object as $content)
		{
			$contents[]['name'] = $content->name;
		}
		$contents = new ArrayList($contents);
		
		return $this->customise(array(
			'Forms' => $forms,
			'DynamicContent' => $contents
		))->renderWith(array("PardotModalForm"));
	}
}