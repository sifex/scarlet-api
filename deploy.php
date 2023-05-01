<?php

namespace Deployer;

use Dotenv\Dotenv;

require 'recipe/laravel.php';
// require './setup/deploy/deploy.php';
// require './setup/deploy/build.php';
// require './setup/deploy/status.php'; // TODO Removed for now, will re-instate later
// require './setup/deploy/sentry.php'; // Custom Override

/*
 * Laravel
 */
// Set it so apache can write to cache
set('writable_chmod_mode', '777');

// Env
// with(new Dotenv());

// Project name
set('application', 'Scarlet');

// Project repository
set('repository', 'git@github.com:sifex/scarlet.australianarmedforces.org.git');
set('allow_anonymous_stats', false);

/*
 * Sentry
 */
//set('sentry', [
//    'organization' => 'platform',
//    'project' => 'api',
//    'token' => 'cc4d6627ba3d44b5a742723dbdff313810ba63e552644e7088a5aa8100c06c4f',
//]);
// after('success', 'deploy:sentry');

// Hosts
inventory('.hosts.yml');
