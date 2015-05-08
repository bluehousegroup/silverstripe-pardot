SilverStripe Pardot
=====================
Extension to integrate Pardot with your SilverStripe Site.

##Features
* Adds tracking codes based on campaign to entire site.
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot1.png)
* Shortcode api for dropping in forms and dynamic content from the Pardot dashboard into SilverStripe.

##Requirements
* SilverStripe 3+

##Configuration
Visit http://yoursite.com/dev/build/?flush=1 to configure database for Pardot Api credentials.

Go to the CMS settings and click on the Pardot tab and add Pardot account credentials.

##Tracking
To add tracking codes to your site simply add the following to your template. 
<pre>$GetPardotTrackingJs</pre>

##Pardot Forms and Dynamic Content shortcode

Shortcodes are injected from a modal available from the Pardot button
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot2.png)

Simply choose the form or dynamic content to insert
![Screenshot](https://github.com/bluehousegroup/silverstripe-pardot/blob/master/SilverStripePardotScreenShot3.png)