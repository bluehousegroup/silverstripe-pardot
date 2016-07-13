SilverStripe Pardot
=====================
A module to integrate Pardot with your SilverStripe Site.

Pardot is a full-featured marketing automation tool that’s easy to use. Pardot’s platform features CRM integration, email marketing, lead nurturing, lead scoring and grading, social posting, and ROI reporting to help marketing and sales teams work together to generate and qualify sales leads, shorten sales cycles, and demonstrate marketing accountability.

##Features
* Adds tracking codes based on campaign to entire site.
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot1.png)
* Shortcode api for dropping in forms and dynamic content from the Pardot dashboard into SilverStripe.

##Requirements
* SilverStripe 3+

### Install with Composer  
	composer require bluehousegroup/silverstripe-pardot

##Configuration
Visit http://yoursite.com/dev/build/?flush=1 to configure database for Pardot Api credentials.

Go to the CMS settings and click on the Pardot tab and add Pardot account credentials.

##Tracking
To add tracking codes to your site simply add the following to your template. 
<pre>$GetPardotTrackingJs</pre>

##Pardot Forms and Dynamic Content shortcode

Shortcodes are injected from a modal available from the Pardot button
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot3.png)

Simply choose the form or dynamic content to insert
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot2.png)
