<?php


defined('MOODLE_INTERNAL') || die;

$capabilities = array(



    'block/googlesuchevisual:addinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'guest' => CAP_PREVENT,       // Prevent Guest user.
            'user' => CAP_PREVENT,        // Prevent Authenticated user.
            'student' => CAP_PREVENT,     // Prevent Student user.
            'teacher' => CAP_PREVENT,     // Prevent teacher user.
            'editingteacher' => CAP_ALLOW,// Allow Editingteacher user.
            'coursecreator' => CAP_ALLOW, // Allow Coursecreator user.
            'manager' => CAP_ALLOW        // Allow Manager user.
        ),
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ),

   

    'block/googlesuchevisual:myaddinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'guest' => CAP_PREVENT,       // Prevent Guest user.
            'user' => CAP_PREVENT,        // Prevent Authenticated user.
            'student' => CAP_PREVENT,     // Prevent Student user.
            'teacher' => CAP_PREVENT,     // Prevent teacher user.
            'editingteacher' => CAP_ALLOW,// Allow Editingteacher user.
            'coursecreator' => CAP_ALLOW, // Allow Coursecreator user.
            'manager' => CAP_ALLOW        // Allow Manager user.
        ),
        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    )
);
