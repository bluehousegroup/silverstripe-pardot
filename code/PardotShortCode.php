<?php
/**
*Class for parsing shortcode for pardot forms and dynamic content.
*
* PardotForm() and PardotDynamicContent() are the two endpoints for 
* the pardot shortcode api. 
*
* The Class is designed so that the cache does not need to be reset by a user.
* The API is called when the the cache is empty, or if the content in the cache
* doesn't match the requested content name or title, effectively  resetting  the cache. 
* 
* shortcode endpoints configured in _config.php
*
*/

class PardotShortCode extends SiteTree 
{

	private static $casting = array(

		'PardotForm' => 'HTMLText',
		'PardotDynamicContent'=>'HTMLText'
	);
	
	/**
	* call back for pardot form shortcode. 
	*
	* @param array $arguments Values 'title' supported
	* @return string embed_code if the title of the form exists
	*/
	public static function PardotForm($arguments, $content = null, $parser = null, $tagName)
	{
		
		if(isset($arguments["title"]))
		{
			if($embed_code = Self::getFormEmbedCodeFromCache($arguments["title"]))
			{
				return Self::addAttributes($embed_code, $arguments, 'Form');
			}
			else// refresh the cache and look again
			{
				Self::cacheFormsFromPardotApi();
				if($embed_code = Self::getFormEmbedCodeFromCache($arguments["title"]))
				{
					return Self::addAttributes($embed_code, $arguments, 'Form');
				}
			}
		}
		
		return "";
	}

	/**
	*call back for pardot dynamic content
	*
	*@param array $arguments Values 'name' supported
	*@return string embed_code if the name of the dynamic content exists
	*/
	public static function PardotDynamicContent($arguments, $content = null, $parser = null, $tagName)
	{
		
		if(isset($arguments["name"]))
		{
			if($embed_code = Self::getDynamicContentEmbedCodeFromCache($arguments["name"]))
			{
				return Self::addAttributes($embed_code, $arguments, 'DynamicContent');
			}
			else// refresh the cache and look again
			{
				Self::cacheDynamicContentFromPardotApi();
				if($embed_code = Self::getDynamicContentFromCache($arguments["name"]))
				{
					return Self::addAttributes($embed_code, $arguments, 'DynamicContent');
				}
			}
		}
	
		return "";
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
			if(Self::checkNameOrTitleEqual($formTitle, $form->name))
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
		$dynamicContents = Self::getDynamicContentFromCache();
		foreach($dynamicContents as $dynamicContent)
			if(Self::checkNameOrTitleEqual($dynamicContentTitle,$dynamicContent->name))
				return $dynamicContent->embedCode;

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

	/**
	* checks equivalence of two strings white space and capitalization doesnt matter
	*
	* Used to make api parameters more forgiving
	* @param string item1
	* @param string item2
	* bool true if strings are equal after removing whitespace and converted to lowercase.
	*/
	private static function checkNameOrTitleEqual($item1, $item2)
	{
		return strtolower(str_replace(" ","",$item1)) == strtolower(str_replace(" ","",$item2));
	}

	/**
	*add the other attributes included to the embed code
	*supports type = 'Form' or 'DynamicContent'
	*/
	public static function addAttributes($embed_code, $arguments, $type)
	{
		if($type == 'Form')
		{
			if(isset($arguments['height']))
			{
				if(preg_match( '#height="[^"]+"#', $embed_code, $matches))
				{
					$embed_code = str_replace($matches[0], "height=\"{$arguments['height']}\"", $embed_code);
				}
				else
				{
					$embed_code = str_replace('iframe', "iframe height=\"{$arguments['height']}\"", $embed_code);
				}
			}
			if(isset($arguments['width']))
			{
				if ( preg_match( '#width="[^"]+"#', $embed_code, $matches ) )
				{
					$embed_code = str_replace($matches[0], "width=\"{$arguments['width']}\"", $embed_code);
				}
				else
				{
					$embed_code = str_replace('iframe', "iframe width=\"{$arguments['width']}\"", $embed_code);
				}
			}
			if(isset($arguments['classes']))
			{

			}

			return $embed_code;
		}
		elseif($type == 'DynamicContent')
		{
			if(isset($arguments['height']))
			{
				$embed_code = str_replace( 'height:auto', "height:{$arguments['height']}", $embed_code );
			}
			if(isset($arguments['width']))
			{
				$embed_code = str_replace( 'width:auto', "width:{$arguments['width']}", $embed_code );
			}
			if(isset($arguments['classes']))
			{
				$embed_code = str_replace( 'pardotdc', "pardotdc {$arguments['classes']}", $embed_code );
			}

			return $embed_code;
		}
		else
		{
			return $embed_code;
		}
	}
}