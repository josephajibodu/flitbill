<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';

// Config

set('repository', 'git@github.com:josephajibodu/flitbill.git');
set('remote_user', 'josephajibodu');

set('identity_file', '~/.ssh/id_ed25519');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', [
    'storage/app/private'
]);

// Hosts

host('prod')
    ->setHostname('64.227.73.131')
    ->setDeployPath('/var/www/54stores.com/html');

// Tasks

task('npm:build', function () {
    run('cd {{release_path}} && {{bin/npm}} run build');
});

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'npm:install',
    'npm:build',
    'artisan:storage:link',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:view:cache',
    'artisan:event:cache',
    'artisan:migrate',
    'deploy:publish',
]);

// Hooks

after('deploy:failed', 'deploy:unlock');