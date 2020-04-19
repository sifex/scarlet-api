<?php

/**
 * Platform Custom Sentry Deploy Script.
 */

namespace Deployer;

function randString($l = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdef', ceil($l / strlen($x)))), 1, $l);
}

/*
 * Building Frontend App
 */
desc('Building Frontend App');
task('fe:build', [
    'flip:vars',
    'fe:build:local',
]);

task('fe:build:local', function () {
    /** @var string $build_string #####-############################# */
    /**                                | Frontend Build                     */
    /**                                       | Git Revision                */
    $build_string = randString(5).'-'.run('git rev-parse --short HEAD');
    cd('frontend');
    run('yarn install');
    set('env', ['VUE_APP_SENTRY_RELEASE' => $build_string]);
    run('./node_modules/@sentry/cli/bin/sentry-cli releases set-commits "'.$build_string.'" --auto');
    run('yarn run build -- --mode=platform.'.host('local')->get('stage'));
    run('rm -rf dist/**/*.js.map');
    run('./node_modules/@sentry/cli/bin/sentry-cli releases deploys '.$build_string.' new -e '.host('local')->get('stage'));
})->local();

/*
 * Building Marketing Website
 */
desc('Building Marketing App');
task('mark:build', [
    'flip:vars',
    'mark:build:local',
]);

task('mark:build:local', function () {
    cd('marketing');
    run('yarn install');
    run('yarn run build -- --mode=platform.'.host('local')->get('stage'));
})->local();

/*
 * For any of the frontend to receive variables
 * we need to flip all the host variables to localhost for this deployment
 */
desc('Passing Environment variables to JS Application');
task('flip:vars', function () {
    $vars = ['horizon_name', 'stage'];
    foreach ($vars as $var) {
        if (has($var)) {
            host('local')->set($var, get($var));
        }
        writeln('<question>Writing '.($var).' = '.get($var).' to JS Application</question>');
    }
});

desc('Building App');
task('build', [
    'flip:vars',
    'mark:build:local',
    'fe:build:local',
    // 'statuspage:rebuild'
]);

desc('Building and Deploying App');
task('thrust', [
    'build',
    'deploy',
]);
