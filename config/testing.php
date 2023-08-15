<?php
$farmEnums = ['Active', 'Under Construction', 'Retired'];

$turbineEnums = $farmEnums;
$turbineEnums[] = 'Faulty';

return [
    'min_value' => 1,
    'max_value' => 100,
    'start_date' => 2000,
    'end_date' => date('Y'),
    'farm_enum_values' => $farmEnums,
    'turbine_enums' => $turbineEnums
];
