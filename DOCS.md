# Events Documentation

Documentation to reference to when maintaining, building upon, or understanding the CTLT Espresso Controls plugin.

## Table of Contents

1. [Introduction](#introduction)
1. [Discussion](#discussion)
	- [ctlt-espresso-controls.php](#ctlt-espresso-controlsphp)
	- [class.ctlt-espresso-controls.php](#classctlt-espresso-controlsphp)
	- [class.ctlt-espresso-metaboxes.php](#classctlt-espresso-metaboxesphp)
	- [class.ctlt-espresso-handouts.php](#classctlt-espresso-handoutsphp)
	- [class.ctlt-espresso-room-setup.php](#classctlt-espresso-room-setupphp)
	- [class.ctlt-espresso-additional-information.php](#classctlt-espresso-additional-informationphp)
	- [class.ctlt-espresso-additional-requirements.php](#classctlt-espresso-additional-requirementsphp)
	- [class.ctlt-espresso-costs.php](#classctlt-espresso-costsphp)
	- [class.ctlt-espresso-saving.php](#classctlt-espresso-savingphp)

## Introduction

This documentation serves to provide reference material for developers who wish to maintain or build upon this plugin. This documentation only applies to the version of the plugin that is compatible to Event Espresso 3.1.4+ up to version 4.0 exclusively and as such should not be referenced for any other versions other than the aforementioned ones.

## Discussion

The purpose of this plugin was to create administrative control panels for the Event Espresso event management system in order to recreate the functionality of the previous events management system at [http://events.ctlt.ubc.ca](http://events.ctlt.ubc.ca) for the Centre for Teaching, Learning and Technology (CTLT).

In order to create the control panels, action hooks into the core code of the Event Espresso plugin were required. Two of these hooks, the `action_hook_espresso_edit_event_left_column_advanced_options_top` and `action_hook_espresso_edit_event_left_column_advanced_options_top` are located in the `event-espresso/includes/event-management/add_new_event.php` file and the `event-espresso/includes/event-management/edit_event.php` file respectively. These two hooks are executed when an event is being created or edited.

Two other hooks that are necessary for this plugin are the hooks that are executed during insertion of an event into the database and updating an event in the databse. These two hooks are located in the `event-espresso/includes/event-management/insert_event.php` file and `event-espresso/includes/event-management/update_event.php` file, which represent inserting into the database and updating the database respectively.

If ever the hooks are changed, they can be easily updated within the plugin files for the CTLT Espresso Controls plugin. Simply navigate to the `ctlt-espresso-controls/lib/class.ctlt-espresso-metaboxes.php` file and update accordingly. The hook names defined in the metaboxes file are protected typing and will be inherited by the child classes of `CTLT_Espresso_Metaboxes`. The specific variables that need to be changed if the hook name ever changes are the following:

* `protected $add_hook`
* `protected $edit_hook`
* `protected $update_hook`
* `protected $insert_hook`

As the variables are inherited, the developer will not have to worry about the individual class files breaking due to hardcoding issues. The variables also provide a central place to make changes to the hook values.

The following sections will provide an explanation for each of the important files contained within the plugin.

### ctlt-espresso-controls.php

This file contains the `define` definitions for the entire plugin. This file is also responsible for creating an instance of the main class for the plugin.

### class.ctlt-espresso-controls.php

The CTLT_Espresso_Controls class can be found to be defined in the `ctlt-espresso-controls/class.ctlt-espresso-controls.php` file. This class is responsible for including the other classes that are needed to create the meta boxes required for the plugin to operate properly. The files that are used to create the control panel are only included when WordPress is in the administrative dashboard. Only when WordPress is in the administrative dashboard will the plugin files be loaded. This file also contains two additional functions that can be used anywhere. The first function is a public class function, `frontend_get_data()` which grabs relevant data from the events meta table by event id. The second function is the `array_column()` function that is normally only available for versions of PHP >= 5.5.0 but redefined here if there doesn't already exist an `array_column()` function (i.e. PHP 5 < 5.5.0). The `array-column()` function is written by [Ben Ramsey](http://benramsey.com) and is licensed under the MIT license. The source code can be found in the following [GitHub repository](https://github.com/ramsey/array_column).

### class.ctlt-espresso-metaboxes.php

The CTLT_Espresso_Metaboxes class can be found to be defined in the `ctlt-espresso-controls/lib/class.ctlt-espresso-metaboxes.php` file. This class contains all of the hook names that the rest of the plugin will use and inherit from. The class also contains a function that will execute on event edit that will load the relevant data from the events meta table and allow the children classes to display previously inserted/updated data from the same event id. In the event that the `$insert_hook` and `$update_hook` are not added to the Event Espresso core files, they can be added to the `event-espresso/includes/event-management/insert_event.php` file and the `event-espresso/includes/event-management/update_event.php` file. For the `insert_event.php` file, simply add a `do_action( 'INSERT HOOK GOES HERE', $last_event_id );` underneath the if statement block where event posts are added to the database. For the `update_event.php` file, add a `do_action( 'UPDATE HOOK GOES HERE', $event_id );` underneath the if statement block where event posts are updated to the database.

### class.ctlt-espresso-handouts.php

The CTLT_Espresso_Handouts class can be found defined in the `ctlt-espresso-controls/lib/class.ctlt-espresso-handouts.php` file. This class handles the rendering of the handouts meta box and is a child class of CTLT_Espresso_Metaboxes. The contents of the meta box can be changed by modifying the value of the two arrays. The `$radios_arr` array handles the content of the radio buttons in the handouts meta box and the `$handout_file` array handles the content of the upload file input area. If the handout radio buttons have not been checked previously, it will default to the N/A radio button the next time the event is being edited, otherwise it will select the radio button that was chosen previously.

### class.ctlt-espresso-room-setup.php

The CTLT_Espresso_Room_Setup class can be found defined in the `ctlt-espresso-controls/lib/class.ctlt-espresso-room-setup.php` file. This class handles the rendering of the room setup meta box and is a child class of CTLT_Espresso_Metaboxes. The source images used by this class are found in the `ctlt-espresso-controls/assets` directory. To modify the contents of the room setup meta box, only the `$rooms` array will need to be modified. If the room setup style has already been selected, the next time the event is being edited the appropriate radio button will be checked, otherwise it will default to the open space room style.

### class.ctlt-espresso-additional-information.php

The CTLT_Espresso_Additional_Information class can be found defined in the `ctlt-espresso-controls/lib/class.ctlt-espresso-additional-information.php` file. This class handles the rendering of the additional information meta box and is a child class of CTLT_Espresso_Metaboxes. The meta box contains two sections, the textarea inputs and the checkboxes. The textarea input fields are managed by the `$add_info` array and rendered by the `the_textboxes()` function. The checkboxes are managed by the `$checks` array and rendered by the `the_checkboxes()` function. Both functions check if there are already existing values for the input areas and will fill in the information to the appropriate fields.

### class.ctlt-espresso-additional-requirements.php

The CTLT_Espresso_Additional_Requirements class can be found defined in the `ctlt-espresso-controls/lib/class.ctlt-espresso-additional-requirements.php` file. This class handles the rendering of the additional requirements meta box and is a child class of CTLT_Espresso_Metaboxes. The CTLT_Espresso_Additional_Requirements class is not to be confused with the CTLT_Espresso_Additional_Information class. In this file there are four arrays that are used to control the rendering of the meta box contents. The `$computers` array is responsible for the computers radio buttons at the top of the meta box. The `$cables` array is responsible for the cables radio buttons just below the computers radio buttons. The `$misc_computer_stuff` array is responsible for the many checkboxes and other input fields just under the cables radio buttons. The `$misc_computer_stuff` array is further subdivided into two other arrays with keys `checkbox` and `textbox`. The `checkbox` key contains the array for the checkboxes while the `textbox` key contains the arrays for the dropdown and text fields. The `$equipment` array is responsble for the checkboxes under the equipment sub-heading in the meta box. All the fields in this section, like the previous section, will check to see if a previous value was already saved for the event and load that value instead if a value already exists.

### class.ctlt-espresso-costs.php

The CTLT_Espresso_Costs class can be found defined in the `ctlt-espresso-controls/lib/class.ctlt-espresso-costs.php` file. This class handles the rendering of the costs meta box and is a child class of CTLT_Espresso_Metaboxes. The contents of the meta box can be changed by modifying the values of the `$costs` array. The input boxes themselves are rendered by the `the_number_boxes()` function and like the other sections, will contain the previously entered value in the input box, but otherwise will default to 0 if not filled in previously.

### class.ctlt-espresso-saving.php

The CTLT_Espresso_Saving class can be found defined in the `ctlt-espresso-controls/lib/class.ctlt-espresso-saving.php` file. This class handles most of the database functions for inserting, updating and getting data. The data is saved and grabbed from the events meta table and requires the use of the two hooks from `insert_event.php` and `update_event.php` in the Event Espresso core files. When inserting into the events meta table, all the values from the input form fields are saved regardless if they have been checked or filled in. The values for the fields that are not filled are saved as a default value such as empty strings or a default radio button field. The data is gathered by taking advantage of the php `$_POST` array and then targeting the appropriate input fields that are described in the individual meta box classes as well as the event id that is generated in the `insert_event.php` file. Once all of the appropriate data is gathered, insertion to the events meta table will take place. Updating information is handled almost exactly the same way as inserting data into the events meta table. Getting data from the events data table is accomplished by providing the event id and calling the static function `get_from_db( $event_id )`. This function is called in the CTLT_Espresso_Metaboxes class when the action hook for editing events is fired.