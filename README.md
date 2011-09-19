Get Your GreenBack Tompkins
==============================

This is the web application for Get Your GreenBack Tompkins.

It is build upon Symfony2.  It uses the CCETC versions of the SonataAdminBundle and FOSUserBundle.

Symfony vendors/bundles and some other bundles are installed through ``deps`` and ``bin/vendors install``.  CCETC bundles and KnpLabs bundles are install as git submodules.


#Requirements
https://github.com/CCETC/SonataAdminBundle

https://github.com/CCETC/FOSUserBundle

https://github.com/CCETC/ErrorReportBundle


#Installation
###1. Clone repository:

	$ git clone git@github.com:username/Spoon-Knife.git

###2. Install vendors:

	$ bin/vendors install

###3. Update submodules

	$ git submodules update
	
###4. Fill out fields in ``app/parameters.ini``