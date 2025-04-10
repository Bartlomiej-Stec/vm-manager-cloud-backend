<?php 

return [ 
    'namespace' => env('SERVICE_BUS_NAMESPACE', 'work-pybox'),
    'queue_name' => env('SERVICE_BUS_QUEUE_NAME', 'work'), 
    'sas_key_name' => env('SERVICE_BUS_SAS_KEY_NAME', 'RootManageSharedAccessKey'), 
    'sas_key' => env('SERVICE_BUS_SAS_KEY', ''),
];