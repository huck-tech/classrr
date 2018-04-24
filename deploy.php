<?php
namespace Deployer;
require 'recipe/laravel.php';

// Configuration

set('repository', 'git@bitbucket.org:koder-a/airdojo.git');

add('shared_files', []);
add('shared_dirs', []);

add('writable_dirs', []);

// Servers

server('production', 'domain.com')
    ->user('username')
    ->identityFile()
    ->set('deploy_path', '/var/www/domain.com');

server('qa', 'dev.teachinclass.com')
    ->user('koder')
    ->identityFile()
    ->set('deploy_path', '/home/koder/apps/airdojo');


// Tasks

desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
after('deploy:symlink', 'php-fpm:restart');
