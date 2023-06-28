# CacheControl_J4
Useful Joomla 4.x plugin that turns off joomla caching for the desired pages by using URL based parameters.  
PLEASE DO NOT FORGET TO ENABLE THE PLUGIN!  

CacheControl is an easy to use plugin where you can define on what pages and components caching should be turned off.  
This can help if you are using extensions that have trouble with the Joomla! cache.  
  
(runs on Joomla 4.x only -> for a Joomla 3.x version see here -> https://github.com/BlackBrix/CacheControl_J3 )  
  

  
----    
  
originally invented by Crosstec GmbH &amp; Co. KG (2013)  www.crosstec.de  
  
modified for Jooomla 4.x by "SharkyKZ" (2023) at https://forum.joomla.org
  
"Documentation" (old J3 Version):   
https://crosstec.org/en/forums/1-forums/72050-documentation-for-cache-control-plugin.html  
  
----  
  
  
<img src="CacheControl_J4_settings.png">
   
    
----  
  
  
  

### "Documentation":
it is quite easy:  

- Each line defines a rule that fires disabling the joomla cache

- Each rule should contain url parameters that the plugin should listen to, if they match, the cache will be turned off as soon as a page is called to sends these url parameters.

#### For example:

option=com_content  
option=com_breezingforms

These 2 rules will disable caching entirely as soon as a page is called that sends these parameters

#### Another example:

option=com_content&id=999

This rule will stop caching for the article with the ID "999", only.

However, if you have SEF enabled, you might not see the parameters that are sent.  
In that case, disable SEF completely, load the site (or component) you want to stop caching for, write down the parameters that should trigger a rule, and finally switch back to SEF again.
   
    
----  
  
  
  
### Settings:  
#### Rules:  
Add a line for each rule.   
Each line consists of a list of url parameters.   
For instance:   
option=com_content&amp;view=article   
would turn off caching for com_content in article view. 
    
You can also use '?' for any value,    
for instance:      
option=com_content&amp;view=article&amp;id=?  
  
Please do not forget to enable the plugin!  
  
#### Re-Enable Caching After Dispatch:  
Wether caching should be re-enabled after a rule fired.   
By that the page will be cached partially, but components such as com_content won't be cached.  
This option doesn't work if the joomla cache plugin is enabled.  
