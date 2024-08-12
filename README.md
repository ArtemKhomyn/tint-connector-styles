CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Installation
 * Configuration
 * Functionality
 * Maintainers

INTRODUCTION
------------

This module creates a new field type that allows you to setup _Adimo Buy Button_
in any type of entity. It allows guiding shoppers to your products and follow
them along every step of the purchasing funnel. It’s one of the most
sophisticated and effective marketing solutions for product items.

REQUIREMENTS
------------

This module requires the following modules:

* Migrate Source CSV (https://www.drupal.org/project/migrate_source_csv)

INSTALLATION
------------

* Install as you would normally install a contributed Drupal module. Visit
   https://www.drupal.org/node/1897420 for further information.


CONFIGURATION
-------------

1. Visit the _Manage fields_ tab of the entity bundle where you want to add the
_Adimo Buy Button_
2. Add a new field of type _Adimo BuyNow_.
3. Configure and save the field settings.
4. Visit the _Manage display_ tab of the entity bundle where you added the new
field and place the field in the desired region.


FUNCTIONALITY
-------------

* The _Adimo Buy Button_ field type provides the following fields:
  - **Adimo Integration Type**: The type of integration to be used. This
  determines the behavior of the button.
  - **Adimo Touchpoint ID**: The touchpoint ID to be used.
  - **Adimo Widget Custom CSS**: The custom CSS to be used.
  - **Custom Button HTML**: The custom HTML to be used.

* Bulk import of Adimo IDs:
  - Go to `/admin/config/lightnest/ln-adimo/field-update`
  - Choose an Adimo widget field in the dropdown to import data into from the
  CSV file.
  - Select the widget style to attach to the products in your CSV upload file.
  - Enter your custom button HTML and CSS if you want to override the default
  values.
  - Download the CSV sample file, populate with your own data and upload it.

MAINTAINERS
-----------

* Nestle Webcms team.
