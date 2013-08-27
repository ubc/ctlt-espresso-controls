# Events Documentation

Documentation to reference to when maintaining, building upon, or understanding the CTLT Espresso Controls plugin.

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

### class.ctlt-espresso-controls.php

The CTLT_Espresso_Controls class can be found to be defined in the `ctlt-espresso-controls/class.ctlt-espresso-controls.php` file. This class is responsible for including the other classes that are needed to create the meta boxes required for the plugin to operate properly. The files that are used to create the control panel are only included when WordPress is in the administrative dashboard.

### class.ctlt-espresso-metaboxes.php

### class.ctlt-espresso-handouts.php

### class.ctlt-espresso-room-setup.php

### class.ctlt-espresso-additional-information.php

### class.ctlt-espresso-additional-requirements.php

### class.ctlt-espresso-costs.php

### class.ctlt-espresso-saving.php

## Conclusion

## Recommendation