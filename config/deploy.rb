set :application, "podcast-admin.open.ac.uk"
set :repository,  "git://github.com/jamiedaniesl123/podcast.git"
set :branch, "11-08-11"
set :scm, :git
set :deploy_to, "/data/web/#{application}/www"
set :cakephp_app_path, "/data/web/#{application}/www/app"
set :cakephp_core_path, "/data/web/#{application}/www/cake"
set :shard_dir, "shared"
set :use_sudo, false
set :keep_releases, 2
set :copy_exclude, [".git",".gitignore"]
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `git`, `mercurial`, `perforce`, `subversion` or `none`

role :app, "jdd7@ou-media03"                          # This may be the same as your `Web` server

# If you are using Passenger mod_rails uncomment this:
# if you're still using the script/reapear helper you will need
# these http://github.com/rails/irs_process_scripts

namespace :deploy do 

 	task :finalize_update, :roles => :app do 
        # link a custom configurations files and folders
		run "ln -s #{deploy_to}/#{shared_dir}/config/core.php #{current_release}/app/config/core.php" 
		run "ln -s #{deploy_to}/#{shared_dir}/config/database.php #{current_release}/app/config/database.php"
		run "ln -s #{deploy_to}/#{shared_dir}/config/call_fc.php #{current_release}/app/webroot/upload/call_fc.php"
		run "ln -s #{deploy_to}/#{shared_dir}/files #{current_release}/app/webroot/upload/files"
		run "mkdir #{current_release}/app/tmp"
		run "ln -s #{deploy_to}/#{shared_dir}/tmp #{current_release}/app/tmp/cache"
		run "ln -s #{deploy_to}/#{shared_dir}/config/.htaccess_root #{current_release}/.htaccess"
		run "ln -s #{deploy_to}/#{shared_dir}/config/.htaccess_webroot #{current_release}/app/webroot/.htaccess"
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