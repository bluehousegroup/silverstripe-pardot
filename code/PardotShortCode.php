<?php
class PardotShortCode extends SiteTree 
{

	private static $casting = array(
        	
        'PardotForm' => 'HTMLText'
    );

	  public function PardotForm($arguments, $content = null, $parser = null, $tagName)
	  {
        
        return "hello world";
    
      }
}
