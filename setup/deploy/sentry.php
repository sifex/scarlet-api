<?php

/**
 * Platform Custom Sentry Deploy Script.
 */

namespace Deployer;

desc('Notifying Sentry of deployment');
task('deploy:sentry', function () {
    $defaultConfig = [
        'version'       => trim(runLocally('git log -n 1 --format="%h"')),
        'ref'           => null,
        'url'           => null,
        'commit'       => trim(runLocally('git log -n 1 --format="%H"')),
        'date_started'   => date('c'),
        'date_released'  => date('c'),
        'sentry_server'  => 'https://sentry.io',
    ];

    $config = array_merge($defaultConfig, (array) get('sentry'));

    if (! is_array($config) || ! isset($config['organization']) || ! isset($config['project']) || ! isset($config['token']) || ! isset($config['version'])) {
        throw new \RuntimeException("Please configure new sentry: set('sentry', ['organization' => 'example org', 'project' => 'example proj', 'token' => 'd47828...', 'version' => '0.0.1']);");
    }

    $postData = [
        'version'       => $config['version'],
        'ref'           => $config['ref'],
        'url'           => $config['url'],
        'commit'        => $config['commit'],
        'dateStarted'   => $config['date_started'],
        'dateReleased'  => $config['date_released'],
    ];

    $options = ['http' => [
        'method' => 'POST',
        'header' => 'Authorization: Bearer '.$config['token']."\r\n"."Content-type: application/json\r\n",
        'content' => json_encode($postData),
    ]];

    $context = stream_context_create($options);
    $result = file_get_contents($config['sentry_server'].'/api/0/projects/'.$config['organization'].'/'.$config['project'].'/releases/', false, $context);

    if (! $result) {
        throw new \RuntimeException($php_errormsg);
    }
});
