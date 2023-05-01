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
    ->set('target', 'neo')
    ->setDeployPath('/var/www/staging.scarlet.australianarmedforces.org');

host('production')
    ->setHostname('100.121.183.99')
    ->setRemoteUser('pilot')
    ->setPort(1827)
    ->set('target', 'master')
    ->setDeployPath('/var/www/scarlet.australianarmedforces.org');

host('london')
    ->setForwardAgent(true)
    ->setHostname('100.71.195.41')
    ->setRemoteUser('pilot')
    ->setPort(22)
    ->set('target', 'neo')
    ->setDeployPath('/var/www/london.australianarmedforces.org');

host('london-1')
//    ->setForwardAgent(true)
    ->setHostname('100.76.235.28')
    ->setRemoteUser('pilot')
    ->setPort(22)
    ->set('target', 'neo')
    ->setDeployPath('/var/www/london.australianarmedforces.org');


// Tasks
task('build', function () {
    cd('{{release_path}}');
    run('npm install');
    run('npm run build');
    run('rm -rf node_modules/');
});

after('deploy:vendors', 'build');

after('deploy:failed', 'deploy:unlock');
