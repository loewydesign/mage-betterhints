# Loewy_Betterhints
Adds better template hints to Magento pages in the form of HTML comments.

Before Loewy_Betterhints:

	<div class="breadcrumbs">
	    <ul>
	        <li class="home">
	            <a href="http://example.com/" title="Go to Home Page">Home</a>
	            <span>/ </span>
	        </li>
	        <li class="cms_page">
	            <strong>About Us</strong>
	        </li>
	    </ul>
	</div>

After Loewy_Betterhints:

	<!-- START BLOCK 16
	Class: Mage_Page_Block_Html_Breadcrumbs
	Name: breadcrumbs
	Template: frontend\base\default\template\page/html/breadcrumbs.phtml
	toHtml() Path:
	   + Mage_Page_Block_Html (Name: root Template: frontend\rwd\default\template\page/2columns-left.phtml)
	   +--- Mage_Page_Block_Html_Breadcrumbs (Name: breadcrumbs Template: frontend\base\default\template\page/html/breadcrumbs.phtml) -->
	<div class="breadcrumbs">
	    <ul>
	        <li class="home">
	            <a href="http://example.com/" title="Go to Home Page">Home</a>
	            <span>/ </span>
	        </li>
	        <li class="cms_page">
	            <strong>About Us</strong>
	        </li>
	    </ul>
	</div>
	<!-- END BLOCK 16 -->

Note that the only way to turn the hints on or off at the moment is to enable or disable the module through its config file.