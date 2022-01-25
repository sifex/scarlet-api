<?php

/**
 * Platform Custom Sentry Deploy Script.
 */

namespace Deployer;

/*
 * Laravel Migrate DB
 */
after('deploy:vendors', 'artisan:migrate');

/*
 * Vue CLI Build
 */
// Upload Build
task('fe:upload', function () {
    upload(__DIR__.'/../../frontend/dist/', '{{release_path}}/frontend/dist'); // TODO Fix __DIR__ so relative paths don't have to be used
});

// Upload Build
task('mark:upload', function () {
    upload(__DIR__.'/../../marketing/dist/', '{{release_path}}/marketing/dist'); // TODO Fix __DIR__ so relative paths don't have to be used
});

after('deploy:vendors', 'fe:upload');
after('deploy:vendors', 'mark:upload');

/*
 * Regenerate Roles
 */
task('regen-roles', function () {
    $output = run('{{bin/php}} {{release_path}}/artisan regen-roles');
    writeln('<info>'.$output.'</info>');
});
after('artisan:migrate', 'regen-roles');

/*
 * Horizon
 */
task('horizon:restart', function () {
    if (has('horizon_name')) {
        run('/usr/local/bin/pm2 startOrRestart {{release_path}}/horizon.prod.config.js --only '.get('horizon_name').' --cwd {{release_path}}');
    }
});
after('artisan:optimize', 'horizon:restart');
