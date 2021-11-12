<?php
/*checks if required fields are set, returns false if one isn't*/
/*returns true if all fields are filled in, false if not*/
function checkRequiredFields($input_array,$field_names_array){
    foreach ($field_names_array as $name){
        if(empty($input_array[$name])){
            return false;
        }
    }
    return true;
}

/*validates data length, returns array of invalid keys, the array would be empty if no invalid keys found*/
function validateLength($input_array, $constants_array){
    $out_array = [];
    foreach ($constants_array as $key => $value){
        if(strlen($input_array[$key]) > $constants_array[$key]){
            array_push($out_array,$key);
       }
   }
   return $out_array;
}

/*validates data format
if a key in input array contains the key from patterns, then it will apply
so company_name, first_name, etc will be matched with pattern name
*/
function validateFormat($input_array, $patterns_array){
    $out_array = [];
    foreach ($input_array as $keyA => $valueA){
        foreach ($patterns_array as $keyB => $valueB){
            if (str_contains($keyA,$keyB)){
                if(!(preg_match($valueB,$valueA))){
                    array_push($out_array,$keyB);
                }
            }
        }
    }
    return $out_array;
}

/*
function for sanitizing input so it's safe to save and manipulate
it returns an array and OPTIONAL in any empty values
*/
function sanitize($input_array){
    $out_array = [];
    foreach ($input_array as $key => $value){
        if(str_contains($key,"name") && $value){
            $out_array[$key] = strip_tags(trim($value));
        } else if($key === "email"){
            $out_array[$key] = filter_var(trim($value), FILTER_SANITIZE_EMAIL);
        } else if($key === "phone"){
            $out_array[$key] = trim($value);
        } else if(str_contains($key,"message")){
            $out_array[$key] = htmlspecialchars(trim($value));
        }else{
            $out_array[$key] = "OPTIONAL";
        }
    }
    return $out_array;
}