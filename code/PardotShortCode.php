<?php
class PardotShortCode extends SiteTree 
{

	private static $casting = array(

	    'PardotForm' => 'HTMLText',
	    'PardotDynamicContent'=>'HTMLText'
	);
	
	/**
	* call back for pardot form shortcode
	* 
	* @param array $arguments Values 'title' supported
	* @return string embed_code if the title of the form exists
	*/
	public function PardotForm($arguments, $content = null, $parser = null, $tagName)
	{
		
		if(isset($arguments["title"]))
		{
			error_log($arguments["title"]);
			if($embed_code = Self::getFormEmbedCodeFromCache($arguments["title"]))
			{
				error_log($embed_code);
				return $embed_code;
			}
		}
		
		return "";
	}
	public function PardotDynamicContent($arguments, $content = null, $parser = null, $tagName)
	{
		//$arguments, $content = null, $parser = null, $tagName
		error_log(print_r(Self::cacheDynamicContentFromPardotApi(),1));
		return "hello";
	}

   	/**
   	* Gets html to embed the pardot form based on name of the form.
   	*
   	* @param string $formTitle name of form
   	* @return string | bool html to embed pardot form w/name if exists, false otherwise 
   	*/
   	public static function getFormEmbedCodeFromCache($formTitle)
   	{
   		$forms = Self::getFormsFromCache();
   		foreach($forms as $form)
   			if($formTitle == $form->name)
   				return $form->embedCode;

   		return false;
   	}

   	/**
   	* Gets html to embed the pardot dynamic content based on name of content.
   	*
   	* @param string dynamicContentTitle title of dynamic title 
   	* @return string | bool html to embed pardot dynamic content w/name if exists, false otherwise 
   	*/
   	public static function getDynamicContentEmbedCodeFromCache($dynamicContentTitle)
   	{
   		$forms = Self::getDynamicContentFromCache();
   		foreach($forms as $form)
   			if($dynamicContentTitle == $form->name)
   				return $form->embedCode;

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
 	* Gets array of dynamic content objects
 	* If forms are not available in the cache, then make them available
 	*
 	* @return array Array of dynamic content objects
 	*/
 	public static function getDynamicContentFromCache()
 	{
 		$pardot_cache = SS_Cache::factory('Pardot');
 		
 		if(!$serialized_pardot_dynamic_content = $pardot_cache->load('serialized_dynamic_content'))
 			$unserialized_pardot_dynamic_content = Self::cacheDynamicContentFromPardotApi();
 		else
 			$unserialized_pardot_dynamic_content = unserialize($serialized_pardot_dynamic_content);
 		
 		return $unserialized_pardot_dynamic_content;
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

    /**
	* caches pardot dynamic content from the pardot api.
	*
	* @return array Array of dynamic content objects 
	*/
	public static function cacheDynamicContentFromPardotApi()
    {

	  	$pardot = new Pardot_API(PardotConfig::getPardotCredentials());
	  	$dynamicContent = $pardot->get_dynamicContent();

	  	$pardot_cache = SS_Cache::factory('Pardot');
	  	$pardot_cache->save(serialize($dynamicContent),'serialized_dynamic_content');
    	
    	return $dynamicContent;
    }
}