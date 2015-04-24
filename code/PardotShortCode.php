<?php
class PardotShortCode extends SiteTree 
{

	private static $casting = array(

	    'PardotForm' => 'HTMLText'
	
	);
	
	/**
	* call back for pardot form shortcode
	* 
	* @param array $arguments Values 'email' supported
	* @return string embed_code if the name of the form exists
	*/
	public function PardotForm($arguments, $content = null, $parser = null, $tagName)
	{
		if(isset($arguments["name"]))
		{
			if($embed_code = Self::getEmbedCodeFromCache($arguments["name"]))
			{
				error_log($embed_code);
				return $embed_code;
			}
		}
		
		return "";
	}

   	/**
   	* Gets html to embed the pardot form based on name of the form.
   	* Case insensitive.
   	*
   	* @param string $formNameNoSpaces name of form with spaces removed
   	* @return string | bool html to embed pardot form w/name if exists, false otherwise 
   	*/
   	public static function getEmbedCodeFromCache($formNameNoSpaces)
   	{
   		$formNameNoSpacesLowerCase = strtolower($formNameNoSpaces);
   		$forms = Self::getFormsFromCache();

   		foreach($forms as $form)
   		{
   			$compareWithFormNameNoSpacesLowerCase = strtolower(str_replace(" ", "", $form->name));
   			if($formNameNoSpacesLowerCase == $compareWithFormNameNoSpacesLowerCase)
   				return $form->embedCode;
   		}
   			
   		return false;
   	}

 	/**
 	* Gets array of form objects
 	* If forms are not available in the cache, then make them available
 	*
 	* @return array Array of form objects
 	*/
 	public static function getFormsFromCache()
 	{
 		$pardot_cache = SS_Cache::factory('Pardot');
 		
 		if(!$serialized_pardot_forms = $pardot_cache->load('serialized_forms'))
 			$unserialized_pardot_forms = Self::cacheFormsFromPardotApi();
 		else
 			$unserialized_pardot_forms = unserialize($serialized_pardot_forms);
 		
 		return $unserialized_pardot_forms;
 	}

    /**
	* caches pardot forms from the pardot api.
	*
	* @return array Array of form objects 
	*/
	public static function cacheFormsFromPardotApi()
    {
	  	$pardot = new Pardot_API(PardotConfig::getPardotCredentials());
	  	$forms = $pardot->get_forms();

	  	$pardot_cache = SS_Cache::factory('Pardot');
	  	$pardot_cache->save(serialize($forms),'serialized_forms');
    	
    	return $forms;
    }
}
