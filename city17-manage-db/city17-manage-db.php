<?php

/**
 * Plugin Name: City17 Manage DB
 */
function add_new_menu_items() {
    add_menu_page(
            "City17 manage DB",
            "City17 manage DB",
            "manage_options",
            "db-settings",
            "db_settings_page",
            "",
            1
    );
    add_submenu_page('db-settings', 'Submissions', 'Submissions', 'manage_options', 'submissions', 'submissions_callback');
}

function submissions_callback() {
    ?>
    <style>
        th{
            font-weight: bold!important;
            border-bottom: solid 2px #ccc;  
        }
    </style>


    <?php
    global $wpdb;
    $table_name = $wpdb->prefix . get_option('db_input');

    $sql = "SELECT * FROM " . $table_name;
    $results = $wpdb->get_results($sql);
    $max = count($results);

    if ($max == 0) {
        ?>
        <h2>No data has been submitted</h2>
        <?php
    } else {
        ?>
        <br /><br />
        <table class="wp-list-table widefat" style="width: 99%">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Country</th>
                <th>Date of Birth</th>
            </tr>
            <?php
            for ($i = 0; $i < $max; $i++) {
                echo "<tr>";
                echo "  <td>" . $results[$i]->fname . "</td>";
                echo "  <td>" . $results[$i]->lname . "</td>";
                echo "  <td>" . $results[$i]->email . "</td>";
                echo "  <td>" . $results[$i]->phone . "</td>";
                echo "  <td>" . $results[$i]->country . "</td>";
                echo "  <td>" . $results[$i]->date . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <?php
}

function db_settings_page() {
    ?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"></div>
        <h1>Theme Options</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields("db_settings");

            do_settings_sections("db-settings");

            submit_button();
            ?>          
        </form>
    </div>
    <?php
}

add_action("admin_menu", "add_new_menu_items");

function display_options() {

    add_settings_section("db_settings", "DB Settings", "display_db_settings", "db-settings");

    add_settings_field("db_input", "DB Name: ", "display_db_input", "db-settings", "db_settings");

    register_setting("db_settings", "db_input");
}

function display_db_settings() {
    echo "The header of the theme";
}

function display_db_input() {
    //id and name of form element should be same as the setting name.
    ?>

    <input style="width: 600px; direction: ltr" type="text" name="db_input" id="db_input" value="<?php echo get_option('db_input'); ?>" />
    <?php
}

add_action("admin_init", "display_options");

function db_updated_option($option_name, $old_value, $value) {
    if ($option_name === 'db_input') {
        global $wpdb;
        $dropTablename = $wpdb->prefix . $old_value;
        $createTablename = $wpdb->prefix . $value;

        $sqlDrop = "DROP TABLE IF EXISTS `" . $dropTablename . "`";
        $wpdb->query($sqlDrop);

        $sqlCreate = " CREATE TABLE `" . $createTablename . "` (";
        $sqlCreate .= " `fname` varchar(255)  NULL,";
        $sqlCreate .= " `lname` varchar(255)  NULL,";
        $sqlCreate .= " `email` varchar(255)  NULL,";
        $sqlCreate .= " `phone` varchar(255)  NULL,";
        $sqlCreate .= " `country` varchar(255)  NULL,";
        $sqlCreate .= " `date` varchar(255)  NULL";
        $sqlCreate .= ") ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;";

        $wpdb->query($sqlCreate);
    }
}

add_action('updated_option', 'db_updated_option', 10, 3);


