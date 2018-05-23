<?php
namespace Deployer;

require 'recipe/common.php';
require 'recipe/composer.php';

// デプロイ先
server('production', 'tk2-213-16244.vs.sakura.ne.jp', 22)
  ->user('yuto')
  ->identityFile()
  ->forwardAgent()
  ->env('deploy_path', '/home/yuto/');

set('ssh_type', 'native');

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'https://github.com/Qtakahashi/takahashi-project.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);

// Hosts

host('project.com')
    ->set('deploy_path', '~/{{application}}');    
    

// Tasks

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
