# silverstripe-pardot

Extension to integrate Pardot with your SilverStripe Site.

##Features
* adds tracking codes based on campaign to entire site
* shortcode api for dropping in forms and dynamic content from the pardot dashboard

##Requirements
* SilverStripe 3+

##Tracking
visit http://yoursite.com/dev/build/?flush=1 to configure database for Pardot Api credentials.

Go to the CMS settings and click on the Pardot tab
and add Pardot account credentials.

To add tracking codes to your site simply add the following to your template. 
<pre>$GetPardotTrackingJs</pre>

##Pardot Forms and Dynamic Content shortcode


The shortcode for forms: 
<pre>[pardot_form, title="\\<Form Title\\>"]</pre>

The shortcode for the standard form would be:
<pre>[pardot_form, title="Standard Form"]</pre>

The shortcode for Dynamic Content:
<pre>[pardot_dynamic, name="\\<Dynamic Content Name\\>"]</pre>

The shortcode for Dynamic Content named "Test Content":
<pre> [pardot_dynamic, name="Test Content"] </pre>

If the requested form or dynamic content isn't found then nothing is displayed.