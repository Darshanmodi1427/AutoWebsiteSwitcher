# AutoWebsiteSwitcher
Magento 2 Auto Website Switcher based on GEO IP


To configure Multiple Website Based on GEO Ip please follow below steps.<br/>

<b>step #1:</b> Created multi websites, stores and store views from magento admin panel. Don't forget to change the base url and secure url for new website/store. <br/>

<b>step #2:</b> Install Darsh_WebsiteSwitch module, with extract provided zip file.<br/> 
=> In the zip file "app/code/Darsh" folder contains the multi website switcher code. <br/>
=> "canada", "in", "mexico", "uk", and "usa" folder is created for multiwebsite switcher. Based on your requirement and create website code create folder on magento 2 root. Each module will require "index.php" and ".htaccess".<br/>
=> In magento 2 need to set <b>"Simlinks"</b> to newly created website folder. To set simlinks go to new created folder using SSH and run below commands.<br/>
1) ln -s /var/www/html/XXXX/app/ app 
<br/>
2) ln -s /var/www/html/XXXX/lib/ lib 
<br/>
3) ln -s /var/www/html/XXXX/pub/ pub 
<br/>
4) ln -s /var/www/html/XXXX/var/ var 
<br/>

<b>step #3:</b>
Dont forgot to upload "var/geoip/ip2country/ip2country.dat" to your project var folder.<br/>
<b>step #4:</b>Now Run below commands. To make multi site working correctly.<br/>
php bin/magento setup:upgrade<br/>
php bin/magento setup:static-content:deploy -f
