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
	
	/**
	*CMS fields for configuring Pardot plugin 
	*/ 
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
		
		//option to select campaign available after they have connected
		if(PardotConfig::validApiCredentials())
		{
			$fields->addFieldToTab("Root.Pardot",Self::getCampaignCmsDropdown());
		}
		else
		{
			$fields->addFieldToTab("Root.Pardot",new LiteralField($name = "pardot_campaign", $content = "<p> Once you are connected, re-visit this page and select a campaign.</p>"));
		}
		
		$fields->addFieldToTab("Root.Pardot", 
		 new CheckboxField("pardot_https","Use HTTPS?")
		 );
	}
   
	/**
	*Validates API credentials. Stores API key in database if valid.
	*/
	public function validate(ValidationResult $validationResult)
	{
		$email = $this->owner->pardot_email;
		$password = $this->owner->pardot_password;
		$user_key = $this->owner->pardot_user_key;
		$auth = array('email' =>$email, 'password'=>$password,'user_key' => $user_key);
		$pardot = new Pardot_API();
		$api_key = $pardot->authenticate($auth);
		
		//credentials are good
		if($api_key)
		{
			$this->owner->pardot_api_key = $api_key;
			return true;
		}
		else
		{ 
			return $validationResult->error('Your API credentials are invalid');
		}
	}
	/**
	*gets dropdown field populated with campaigns for user to choose from
	*
	*@return DropdownField displaying pardot campaigns 
	*/
	public static function getCampaignCmsDropdown()
	{
		 $campaign_dropdown = new DropdownField("pardot_campaign","Campaign",Self::getCampaignValuesForCms());
		 $campaign_dropdown->setEmptyString("Select a Campaign");

		 return   $campaign_dropdown;
	}

	/**
	*gets array of campaigns from pardot api formatted for 
	*Silverstripe DropdownField
	*@return array of campaign ids to campaign names
	*/
	public static function getCampaignValuesForCms()
	{   
		$pardot = new Pardot_API(Self::getPardotCredentials());
		$arrayOfCampaignValuesForCms = array();    
		$campaignsFromApi = $pardot->get_campaigns(Self::getPardotCredentials());
		foreach($campaignsFromApi as $campaign)
			$arrayOfCampaignValuesForCms[$campaign->id] = $campaign->name;
		
		return $arrayOfCampaignValuesForCms;
	}

	/**
	*gets array of Pardot API credentials from SiteConfig
	*@return auth array for pardot api
	*/
	public static function getPardotCredentials()
	{	
		 $config = SiteConfig::current_site_config();
		 
		 return array('email'=>$config->pardot_email,'password'=>$config->pardot_password, 'user_key'=>$config->pardot_user_key, 'api_key'=>$config->pardot_api_key);
	}

	/**
	*gets campaign code from database
	*@return string campaign code
	*/
	public static function getCampaignCode()
	{
		$config = SiteConfig::current_site_config();

		return $config->pardot_campaign;
	}


	/**
	*checks current pardot api credentials  
	*@return string api key if valid, empty string if non-valid
	*/
	public static function validApiCredentials()
	{
		$pardot = new Pardot_API();

		return $pardot->authenticate(Self::getPardotCredentials());
	}
}