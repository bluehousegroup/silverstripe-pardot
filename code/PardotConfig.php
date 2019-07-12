<?php

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\Key;

class PardotConfig extends DataExtension
{
    private static $db = array(
        'pardot_email' => 'Varchar',
        'pardot_password' => 'Varchar',
        'pardot_campaign' => 'Varchar',
        'pardot_https' => 'Varchar',
        'pardot_api_key' => 'Varchar',
        'pardot_user_key' => 'Varchar',
    );

    /**
     * CMS fields for configuring Pardot plugin
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab("Root.Pardot",
            new LiteralField($name = "pardot_logo",
            $content = '<div class="field"><img src="/silverstripe-pardot/images/pardot-logo.png" height="50"></div>')
        );

        $fields->addFieldToTab("Root.Pardot",
         new EmailField("pardot_email", "Email Address")
         );

        $password_field = new PasswordField("new_pardot_password", "Password");
        $password_field->setAttribute('placeholder', '********');
        $fields->addFieldToTab("Root.Pardot", $password_field);

        $fields->addFieldToTab("Root.Pardot",
            new TextField("pardot_user_key", "User Key")
        );

        //option to select campaign available after they have connected
        if (PardotConfig::validApiCredentials()) {
            $fields->addFieldToTab("Root.Pardot", self::getCampaignCmsDropdown());
        } else {
            $fields->addFieldToTab("Root.Pardot", new LiteralField($name = "pardot_campaign", $content = '<p class="message bad"> No valid credentials</p>'));
            $fields->addFieldToTab("Root.Pardot", new LiteralField($name = "pardot_campaign", $content = '<p class="message notice"> Once you are connected, re-visit this page and select a campaign.</p>'));
        }

        $fields->addFieldToTab("Root.Pardot",
         new CheckboxField("pardot_https", "Use HTTPS?")
         );

        return $fields;
    }

    /**
     * Validates API credentials. Stores API key in database if valid.
     * @param ValidationResult $validationResult
     * @return bool|void
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public function validate(ValidationResult $validationResult)
    {
        $email = $this->owner->pardot_email;
        $password = self::pardot_decrypt($this->owner->pardot_password);
        $user_key = $this->owner->pardot_user_key;
        $auth = array('email' => $email, 'password' => $password, 'user_key' => $user_key);
        $pardot = new Pardot_API();
        $api_key = $pardot->authenticate($auth);

        //credentials are good
        if ($api_key) {
            $this->owner->pardot_api_key = $api_key;
            return true;
        } else {
            return false;
            //return $validationResult->error('Your API credentials are invalid');
        }
    }

    /**
     * Return the decrypted Pardot password
     * @return string
     */
    protected function getPardotPassword()
    {
        return self::pardot_decrypt($this->owner->pardot_password);
    }

    /**
     * Get pardot key from environment variable
     * @return Key
     * @throws \Defuse\Crypto\Exception\BadFormatException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    protected static function loadEncryptionKeyFromConfig()
    {
        $keyAscii = null;

        if (defined('PARDOT_KEY')) {
            $keyAscii = PARDOT_KEY;
        }

        if (!$keyAscii) {
            throw new RuntimeException('PARDOT_KEY environment variable not set');
        }

        return Key::loadFromAsciiSafeString($keyAscii);
    }

    /**
     * Gets dropdown field populated with campaigns for user to choose from
     * @return DropdownField displaying pardot campaigns
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function getCampaignCmsDropdown()
    {
        $campaign_dropdown = new DropdownField("pardot_campaign", "Campaign", self::getCampaignValuesForCms());
        $campaign_dropdown->setEmptyString("Select a Campaign");

        return $campaign_dropdown;
    }

    /**
     * Gets array of campaigns from Pardot API formatted for a Silverstripe DropdownField
     * @return array
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function getCampaignValuesForCms()
    {
        $pardot = new Pardot_API(self::getPardotCredentials());
        $arrayOfCampaignValuesForCms = array();
        $campaignsFromApi = $pardot->get_campaigns(self::getPardotCredentials()) ?: array();
        foreach ($campaignsFromApi as $campaign) {
            $arrayOfCampaignValuesForCms[$campaign->id] = $campaign->name;
        }

        return $arrayOfCampaignValuesForCms;
    }

    /**
     * Gets array of Pardot API credentials from SiteConfig
     * @return array - auth array for pardot api
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function getPardotCredentials()
    {
        $config = SiteConfig::current_site_config();

        return array('email'=>$config->pardot_email,'password'=> self::pardot_decrypt($config->pardot_password), 'user_key'=>$config->pardot_user_key, 'api_key'=>$config->pardot_api_key);
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

        return $pardot->authenticate(self::getPardotCredentials());
    }

    /**
     * Encrypts with a bit more complexity
     * @param $input_string
     * @return string
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function pardot_encrypt($input_string)
    {
        $key = static::loadEncryptionKeyFromConfig();
        return Crypto::encrypt($input_string, $key);
    }

    /**
     * Decrypts with a bit more complexity
     * @param string $encrypted_input_string
     * @return bool|string
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function pardot_decrypt($encrypted_input_string)
    {
        if (!$encrypted_input_string) {
            return null;
        }

        $key = static::loadEncryptionKeyFromConfig();

        try {
            return Crypto::decrypt($encrypted_input_string, $key);
        } catch (WrongKeyOrModifiedCiphertextException $ex) {
            return false;
        }
    }

    public function onBeforeWrite()
    {
        if (!empty($this->owner->new_pardot_password)) {
            $this->owner->pardot_password = self::pardot_encrypt($this->owner->new_pardot_password);
            $this->owner->new_pardot_password = "";
        }

        parent::onBeforeWrite();
    }
}
