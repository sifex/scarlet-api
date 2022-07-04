<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:sifex/scarlet-api.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('staging')
    ->setHostname('100.121.183.99')
    ->setRemoteUser('pilot')
    ->setPort(1827)
    ->setDeployPath('/var/www/staging.scarlet.australianarmedforces.org');

host('production')
    ->setHostname('100.121.183.99')
    ->setRemoteUser('pilot')
    ->setPort(1827)
    ->setDeployPath('/var/www/scarlet.australianarmedforces.org');

// Tasks

task('build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

after('deploy:failed', 'deploy:unlock');
