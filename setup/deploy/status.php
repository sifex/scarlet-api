<?php

/**
 * Platform Custom Status Page.
 */

namespace Deployer;

/*
 * Status Rebuild
 */
task('statuspage:rebuild', function () {
    cd('status');
    // run('npm install');
    run('npm run generate');
})->local();

// Upload Build
task('statuspage:shove', function () {
    upload(__DIR__.'/../../status/dist/', '{{release_path}}/status/dist'); // TODO Fix __DIR__ so relative paths don't have to be used
});

task('statuspage', [
    'statuspage:rebuild',
    'statuspage:shove',
]);

after('deploy:vendors', 'statuspage:shove');
