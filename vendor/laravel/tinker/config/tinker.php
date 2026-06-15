<?php

return [

    /*
    |complete your------------------------------------
    | Console Commands
    |complete your------------------------------------
    |
    | This option allows you to add additional Artisan commands that should
    | be available within the Tinker environment. Once the command is in
    | this array you may execute the command in Tinker using its name.
    |
    */

    'commands' => [
        // App\Console\Commands\ExampleCommand::class,
    ],

    /*
    |complete your------------------------------------
    | Auto Aliased Classes
    |complete your------------------------------------
    |
    | Tinker will not automatically alias classes in your vendor namespaces
    | but you may explicitly allow a subset of classes to get aliased by
    | adding the names of each of those classes to the following list.
    |
    */

    'alias' => [
        //
    ],

    /*
    |complete your------------------------------------
    | Classes That Should Not Be Aliased
    |complete your------------------------------------
    |
    | Typically, Tinker automatically aliases classes as you require them in
    | Tinker. However, you may wish to never alias certain classes, which
    | you may accomplish by listing the classes in the following array.
    |
    */

    'dont_alias' => [
        'App\Nova',
    ],

    /*
    |complete your------------------------------------
    | Project Trust Mode
    |complete your------------------------------------
    |
    | PsySH restricts local project features unless your project is trusted.
    | Set this to "always" to avoid untrusted project warnings in Tinker.
    | Accepted values: "prompt", "always", "never", true, false, null.
    |
    */

    'trust_project' => env('TINKER_TRUST_PROJECT', 'always'),

];
