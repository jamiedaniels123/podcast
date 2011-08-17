set :application, "media-podcast-api.open.ac.uk"
set :repository,  "git://github.com/jamiedaniesl123/media-api.git"
set :branch, "12-08-11"
set :scm, :git
set :deploy_to, "/data/web/#{application}/www"
set :cakephp_app_path, "/data/web/#{application}/www/app"
set :shard_dir, "shared"
set :use_sudo, false
set :keep_releases, 2
set :copy_exclude, [".git",".gitignore"]
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `git`, `mercurial`, `perforce`, `subversion` or `none`

role :app, "jdd7@ou-media01"                          # This may be the same as your `Web` server

# If you are using Passenger mod_rails uncomment this:
# if you're still using the script/reapear helper you will need
# these http://github.com/rails/irs_process_scripts

namespace :deploy do 

 	task :finalize_update, :roles => :app do 
        # link a custom configurations files and folders
		run "ln -s #{deploy_to}/#{shared_dir}/config/config.php #{current_release}/lib/config.php" 
	end

 	task :shared, :roles => :app do 
   	     # Create shared folder for config files
   	     run "mkdir #{deploy_to}/#{shared_dir}/config"
	end

end