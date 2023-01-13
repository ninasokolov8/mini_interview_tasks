<?php


// TASK - Find the building that is located at the optimate place so you will have the fastest access to wanted facilities
// In this case, the best building is under index 3
$building_desc = [
   
    [
        "gym"=>false,
        "store"=>true,
        "school"=>false,
   ],
    [
        "gym"=>true,
        "store"=>false,
        "school"=>false,
    ],
    [
        "gym"=>true,
        "store"=>false,
        "school"=>false,
    ],
    [
        "gym"=>false,
        "store"=>true,
        "school"=>false,
    ],
    [
        "gym"=>false,
        "store"=>true,
        "school"=>true,
    ],
   
    
];
$wanted_facilities = ["gym","store","school"];
$distance = 1; // how far should i look for wanted facilities? how many buildings far should i check
$multi = false; // do i want to see multiple results

// main function 
function find_best_building($building_desc,$params,$distance,$multi){
    $result = [];
    $building_score_array = [];

    // loop through the buildings
    for($i =0 ; count($building_desc) > $i ;$i++){
        $building_has_it_all = true;
        $building_score_array[$i]= 0;
        $number_of_facilities = count($params);
        
        // loop over wanted facilities list
        for($j =0 ; $number_of_facilities > $j ;$j++){
            // check if the wanted facility exist // true
            if($building_desc[$i][$params[$j]]){
                $building_score_array[$i] ++ ;
            }else{
                $building_has_it_all = false;
                // check surrounding buildings for facilities
                $building_score_array[$i] +=  check_in_distance($distance,$building_desc,$i, $params[$j] );
            }
        }
       // check if the current building has all of the facilities so we will not need to keep searching
        if($number_of_facilities == $building_score_array[$i] &&  $building_has_it_all){
            $building_score_array = [$i => $building_score_array[$i]];
            break;
        }
        
    }
    // get the buildings with best scores
    $result = array_keys($building_score_array, max($building_score_array));
   // do we want to see only 1 building as result?
    if(!$multi){
        $result = [$result[0]];
    }
    print_r($result);
}

// check the facilities in the surrounding buildings 
// using the $distance 
function check_in_distance($distance,$building_desc,$current_key, $facility_key ){
    $result = 0;
    for($d = $distance ; $distance >= $d ; $d++){
        if(isset($building_desc[$current_key-$d])){
            if($building_desc[$current_key-$d][$facility_key]){
                $result = 1;
            }
        }
        if(isset($building_desc[$current_key+$d])){
            if($building_desc[$current_key+$d][$facility_key]){
                $result = 1;
            }
        }
    }
    return $result;
}

// call the function!
find_best_building($building_desc,$wanted_facilities,$distance,$multi);

//  $building_score_array  in case the $distance is 1
//  We are checking the building before and the one after to see if they have the facility we need
//  and changing the building facilities values by that
//  this way we know now which building is the closest building to all the facilities
// (
//     [0] => Array
//         (
//             [gym] => 1
//             [store] => 1
//             [school] => 0
//         )

//     [1] => Array
//         (
//             [gym] => 1
//             [store] => 1
//             [school] => 0
//         )

//     [2] => Array
//         (
//             [gym] => 1
//             [store] => 1
//             [school] => 0
//         )

//     [3] => Array
//         (
//             [gym] => 1
//             [store] => 1
//             [school] => 1
//         )

//     [4] => Array
//         (
//             [gym] => 0
//             [store] => 1
//             [school] => 1
//         )

// )