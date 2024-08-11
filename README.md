CONTENTS OF THIS FILE
---------------------

* Introduction
* Requirements
* Configuration
* Functionality
* Troubleshooting
* Extend
* Development
* Maintainers

INTRODUCTION
------------

This modules provides a _Content: ln_tint_connector_styles that can be used to embed a
TINT social media feed in any page. TINT is a service that integrates all of
your brand's social media posts in one beautiful stream, perfect for embedding
on your website.

INSTALLATION
------------

* Install as you would normally install a contributed Drupal module. Visit
   https://www.drupal.org/node/1897420 for further information.

CONFIGURATION
-------------

* Add a new field of type _Paragraph_ to the content type you want to use the
_Content: ln_tint_connector_styles on.

* Select _Content: Tint_ in the list of allowed paragraph types
for this field and save the field settings.

* If updating from older versions, make sure the **field_c_settings** field is
visible in the display

FUNCTIONALITY
-------------

* The _Content: Tint_ component provides the following fields:
  - **Title**: The title of the component.
  - **Text**: The text to display above the TINT feed.
  - **Tint ID**: The ID from your Tint account for your brand.

  - **TINT Customization Tab**: One of the following display for the TINT custom styles:    
    - **TINT Config Tab**: Custom Styles Customization:
      - **Template**: Grid, Slider, Tile templates 
      - **Max posts**: max count of all posts in new template 
      - **Share Button**: Show/Hide Share buttons for every each post (displaying in every popup post)
      - **Link open method**: Open all links in new or new window tab
    - **Theme color Tab**: Setup all custom colors for custom tint
    - **Slider**: Slider configuration
    - **Grid**: Grid configuration
    - **Tile**: Tile configuration
    - **CTA Group**: Additional paragraph for adding CTA Button for needed post in popup (Can be added max one CTA for every each post)
      - **ID of Post**: == ID of post where will be displayed current CTA 
      - **Link text**: == text for CTA Button
      - **URL**: url for CTA Button

TROUBLESHOOTING
---------------

* If the content does not display correctly, make sure the following template
files are not overriden in your theme's templates directory or a custom module.
If you have overriden these template files, make sure their contents are up to
date with the latest version of the module.
  - `paragraph--dsu-tint.html.twig`

EXTEND
------

* You can implement `hook_theme()` in order to extend the default template of
the paragraph.
* You can implement `hook_preprocess_paragraph()` to alter the data before it
is passed to the template file.
* You can override the default CSS library in your custom theme in order to
change the styling of the component.

DEVELOPMENT
-----------

- In the ln_tint_connector_styles directory, follow these steps:
  - Run yarn install or npm install to install dependencies.
  - Run yarn watch or npm watch to start the watch process.
- After running these commands, you can change SCSS files in assets/scss and JavaScript files in assets/js.

MAINTAINERS
-----------

* Nestle NBS Lviv team.
