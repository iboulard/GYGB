# GYGB - Installation

This application uses Symfony2 and several Symfony bundles.

Symfony vendors/bundles and some other bundles are installed through ``deps`` and ``bin/vendors install``.  CCETC bundles and KnpLabs bundles are install as git submodules.


#Requirements
* <https://github.com/CCETC/SonataAdminBundle>
* <https://github.com/CCETC/FOSUserBundle>
* <https://github.com/CCETC/ErrorReportBundle>
* <https://github.com/CCETC/UserAdminBundle>

#Installation
###1. Clone repository:

	$ git clone git@github.com:CCETC/GYGB.git

###2. Install submodules

	$ git submodule update --init

###3. Create ``app/config/parameters.ini`` from ``app/config/parameters.ini.dist``

###4. Create ``app/config/config_dev.yml`` from ``app/config/config_dev.yml.dist``

###5. Install vendors:

	$ bin/vendors install

###6. Follow installation instructions for dependencies CCETCErrorReportBundle and CCETCUserAdminBundle
	