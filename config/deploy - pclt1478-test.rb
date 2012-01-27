set :application, "podcast.com"
set :repository,  "git://github.com/jamiedaniesl123/podcast.git"
set :branch, "master"
set :scm, :git
set :deploy_to, "/var/www/acceptence.#{application}"
set :cakephp_app_path, "/var/www/acceptence.#{application}/app"
set :cakephp_core_path, "/var/www/acceptence.#{application}/cake"
set :shard_dir, "shared"
set :use_sudo, false
set :keep_releases, 2
set :copy_exclude, [".git",".gitignore"]
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `git`, `mercurial`, `perforce`, `subversion` or `none`

role :app, "jdd7@pclt1478"                          # This may be the same as your `Web` server

# If you are using Passenger mod_rails uncomment this:
# if you're still using the script/reapear helper you will need
# these http://github.com/rails/irs_process_scripts

namespace :deploy do 

 	task :finalize_update, :roles => :app do 
        # link a custom configurations files and folders
		run "ln -s #{deploy_to}/#{shared_dir}/config/core.php #{current_release}/app/config/core.php" 
	    run "ln -s #{deploy_to}/#{shared_dir}/config/database.php #{current_release}/app/config/database.php"
	end
	
 	task :cake, :roles => :app do 
        # Build a cakePHP shared folder structure 
        run "mkdir #{deploy_to}/#{shared_dir}/config"
        run "mkdir #{deploy_to}/#{shared_dir}/files"
        run "mkdir #{deploy_to}/#{shared_dir}/tmp"
        run "chmod -R 777 #{deploy_to}/#{shared_dir}/tmp"
        run "rm -r #{deploy_to}/#{shared_dir}/system"
        run "rm -r #{deploy_to}/#{shared_dir}/pids"
	end
end