<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Redesul
    |--------------------------------------------------------------------------
    |
    |
    */

    'google_sheet_id' => env('GOOGLE_SHEET_ID', ''),
    'google_credentials_file' => storage_path( 'app/public/' . env('GOOGLE_CREDENTIALS_FILE', '')),
    'google_credentials' => env('GOOGLE_CREDENTIALS', ''),

];
