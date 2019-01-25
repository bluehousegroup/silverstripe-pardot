SilverStripe Pardot
=====================
A module to integrate Pardot with your SilverStripe Site.

Pardot is a full-featured marketing automation tool that’s easy to use. Pardot’s platform features CRM integration, email marketing, lead nurturing, lead scoring and grading, social posting, and ROI reporting to help marketing and sales teams work together to generate and qualify sales leads, shorten sales cycles, and demonstrate marketing accountability.

##Features
* Adds tracking codes based on campaign to entire site.
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot1.png)
* Shortcode api for dropping in forms and dynamic content from the Pardot dashboard into SilverStripe.

##Requirements
* PHP 5.5+
* SilverStripe 4+

### Install with Composer

```
composer require bluehousegroup/silverstripe-pardot 2.0.x-dev
```

##Configuration
Add a `PARDOT_KEY` to your `.env` file. 

If there isn't an existing key, you will need to generate a key using `vendor/bin/generate-defuse-key`.

Visit http://yoursite.com/dev/build/?flush=1 to configure database for Pardot Api credentials.

Go to the CMS settings and click on the Pardot tab and add Pardot account credentials.

##Tracking
To add tracking codes to your site simply add the following to your template.

```
$GetPardotTrackingJs
```

##Pardot Forms and Dynamic Content shortcode

Shortcodes are injected from a modal available from the Pardot button
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot3.png)

Simply choose the form or dynamic content to insert
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot2.png)

## Password Encryption
This module uses the [defuse/php-encryption](https://github.com/defuse/php-encryption) module for password encryption.
