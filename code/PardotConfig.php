<?php
class PardotConfig extends DataExtension
{

		
	private static $db = array(
		'pardot_email' => 'Varchar',
		'pardot_password' => 'Varchar',
		'pardot_campaign' => 'Varchar',
		'pardot_https'    => 'Varchar',
		'pardot_api_key'  => 'Varchar',
		'pardot_user_key' => 'Varchar'
	);
  
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Pardot", 
         new EmailField("pardot_email","Email Address")
         );
        $fields->addFieldToTab("Root.Pardot", 
         new PasswordField("pardot_password","Password")
         );
        $fields->addFieldToTab("Root.Pardot",
         new TextField("pardot_user_key","User Key")
        );
        
        $fields->addFieldToTab("Root.Pardot", 
         new DropdownField("pardot_campaign","Campaign",Self::getCampaignValues())
         );
        $fields->addFieldToTab("Root.Pardot", 
         new CheckboxField("pardot_https","Use HTTPS?")
         );
    }
    
    public static function getCampaignValuesForCms()
    {	
    	$pardot = new Pardot_API(Self::getPardotCredentials());
        
        $arrayOfCampaignValuesForCms = array();    
        $campaignsFromApi = $pardot->get_campaigns(Self::getPardotCredentials());
        foreach($campaignsFromApi as $campaign)
            $arrayOfCampaignValuesForCms[$campaign->id] = $campaign->name;
   	    
        return $arrayOfCampaignValuesForCms;
    }


    public static function getPardotCredentials()
    {	
    	 $config = SiteConfig::current_site_config();
    	 return array('email'=>$config->pardot_email,'password'=>$config->pardot_password, 'user_key'=>$config->pardot_user_key);
    }

    public static function getCampaignCode()
    {
        $config = SiteConfig::current_site_config();

        return $config->pardot_campaign;
    }
}