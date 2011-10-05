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

	$ git clone git@github.com:CCETC/GYGB.git

###2. Install submodules

	$ git submodule update --init

###3. Create ``app/config/parameters.ini`` from ``app/config/parameters.ini.dist``

###4. Create ``app/config/config_dev.yml`` from ``app/config/config_dev.yml.dist``

###5. Install vendors:

	$ bin/vendors install
	