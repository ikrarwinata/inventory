<?php

// override core en language system validation or define your own en language validation message
return [
    'errorEmailMissing'					=> 'Email required !',
    'errorURLMissing'			 		=> 'URL required !',
    'errorUsernameMissing'              => 'Username required !',
    'errorUsernameExist'				=> 'Username exist !',
    'errorPasswordMissing'				=> 'Password  cannot be empty !',
    'errorPasswordMismatch'			 	=> 'Invalid password',
    'errorPasswordConfirmMismatch'		=> 'Password confirmation mismatch',
    'errorLoginFailed' 					=> 'Username or Password you given is not found',
    'errorDataNotExist'			 		=> 'Sorry... This data is missing !',
    'errorDataDuplicate'                => 'Sorry... This data already exist !',
    'errorFileNotExist'                 => 'Sorry... This file is missing !',
    'errorAccessDenied'			 		=> 'You don\'t have permission to access this page !!!',
    'nested' => [
        'error' => [
            'message' => 'A specific error message',
        ],
    ],
];
