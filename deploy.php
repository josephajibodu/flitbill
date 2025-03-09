<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';

// Config

set('repository', 'git@github.com:josephajibodu/flitbill.git');
set('remote_user', 'ubuntu');

set('identity_file', '~/.ssh/aws_54stores_ssh_key.pem');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', [
    'storage/app/private'
]);

// Hosts
host('prod')
    ->setHostname('ec2-18-144-6-6.us-west-1.compute.amazonaws.com')
    ->setDeployPath('/var/www/flitbil.com');

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