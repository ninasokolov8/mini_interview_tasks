<?php
// Lets imagine that every number is a color.
// What color taking the most cells (all the specific color cells have to touch each other)
// In this case its "color" 1
$cube_arr = [
    [1, 1, 2, 3],
    [1, 4, 1, 3],
    [1, 1, 2, 3],
    [1, 1, 3, 3]
];


function get_thge_main_number($cube_arr)
{
    // cube height
    $cube_height = count($cube_arr);
    $result_array = [];

    for ($i = 0; $cube_height > $i; $i++) {
        // each row length
        $row_length = count($cube_arr[$i]);

        for ($j = 0; $row_length > $j; $j++) {
            // lets go cell by cell and find the dominant "color" (number in our case)
            check_cell_surrounding($cube_arr, $i, $j, $result_array);
        }
    }
    // get the "color" 
    //$maxs = array_keys($result_array, max($result_array));

    // get all the "colors" results
    // in our case -
    //     Array
    // (
    //     [1] => 6 // in this case "color" 1 is the one that taking the most cells while touching 
    //     [2] => 0
    //     [3] => 4 
    //     [4] => 0
    // )
    print_r($result_array);
}
function check_cell_surrounding(&$cube_arr, $cube_key, $cell_key, &$result_array)
{
    // the current cell value
    $current_cell_value = $cube_arr[$cube_key][$cell_key];

    // if it was previously read, return.
    if ($current_cell_value == "vvv") {
        return;
    }
    // mark the current cell as read.
    $cube_arr[$cube_key][$cell_key] = "vvv";

    if (!key_exists($current_cell_value, $result_array)) {
        $result_array[$current_cell_value] = 0;
    }

    // if we need to check top

    if ($cube_key != 0 && $cube_arr[$cube_key - 1][$cell_key] == $current_cell_value) {
        $result_array[$current_cell_value] += 1;
        // start checking sourrounding of the new cell with the same value
        check_cell_surrounding($cube_arr, $cube_key - 1, $cell_key, $result_array);
    }


    // if we need to check bottom

    if (count($cube_arr) - 1 > $cube_key && $cube_arr[$cube_key + 1][$cell_key] == $current_cell_value) {
        $result_array[$current_cell_value] += 1;
        // start checking sourrounding of the new cell with the same value
        check_cell_surrounding($cube_arr, $cube_key + 1, $cell_key, $result_array);
    }


    // if we need to check left

    if ($cell_key != 0 && $cube_arr[$cube_key][$cell_key - 1] == $current_cell_value) {
        $result_array[$current_cell_value] += 1;
        // start checking sourrounding of the new cell with the same value
        check_cell_surrounding($cube_arr, $cube_key, $cell_key - 1, $result_array);
    }


    // if we need to check right

    if (count($cube_arr[$cube_key]) - 1 > $cell_key && $cube_arr[$cube_key][$cell_key + 1] == $current_cell_value) {
        $result_array[$current_cell_value] += 1;
        // start checking sourrounding of the new cell with the same value
        check_cell_surrounding($cube_arr, $cube_key, $cell_key + 1, $result_array);
    }
}

get_thge_main_number($cube_arr);
