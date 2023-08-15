<?php
$farmEnums = ['Active', 'Under Construction', 'Retired'];
$turbineEnums = $farmEnums;
$turbineEnums[] = 'Faulty';

return [
    'farm_status' => $farmEnums,
    'turbine_status' => $turbineEnums
];
