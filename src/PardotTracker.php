<?php

namespace BluehouseGroup\Pardot;

use Pardot_API;
use SilverStripe\CMS\Model\SiteTreeExtension;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\FieldType\DBField;

class PardotTracker extends SiteTreeExtension
{
    /**
     * Gets tracking code based on campaign
     * @return tracking javascript for pardot api
     */
    public static function GetPardotTrackingJs()
    {
        $html = false;
        $campaign = PardotConfig::getCampaignCode();

        if ($campaign) {
            $tracker_cache = Injector::inst()->get(CacheInterface::class . '.Pardot');

            if (!$tracking_code_template = $tracker_cache->get('pardot_tracking_code_template')) {
                $api_credentials = PardotConfig::getPardotCredentials();
                $pardot = new Pardot_API();
                if (!$pardot->is_authenticated()) {
                    $pardot->authenticate($api_credentials);
                }

                $account = $pardot->get_account();

                if (isset($account->tracking_code_template)) {
                    $tracking_code_template = $account->tracking_code_template;
                    $tracker_cache->set('pardot_tracking_code_template', $tracking_code_template);
                }
            }
            $tracking_code_template = str_replace('%%CAMPAIGN_ID%%', $campaign+1000, $tracking_code_template);
            $campaign = $campaign + 1000;

            $html = <<<HTML
<script type="text/javascript">
piCId = '{$campaign}';
{$tracking_code_template}
</script>
HTML;
        }
        return DBField::create_field('HTMLText', $html);
    }
}
