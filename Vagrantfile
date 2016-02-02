# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

    config.vm.box = "scotch/box"
    config.vm.network "private_network", ip: "192.168.33.10"
    config.vm.hostname = "scotchbox"
    config.vm.synced_folder ".", "/var/www", :mount_options => ["dmode=777", "fmode=666"]
    
    # Optional NFS. Make sure to remove other synced_folder line too
    #config.vm.synced_folder ".", "/var/www", :nfs => { :mount_options => ["dmode=777","fmode=666"] }

	config.vm.provision "shell", inline: <<-SHELL
	    sudo bash -c \'echo export APP_ENV="development" >> /etc/apache2/envvars\'
	    sudo bash -c \'echo export DB_HOST="localhost" >> /etc/apache2/envvars\'
	    sudo bash -c \'echo export DB_PASSWORD="root" >> /etc/apache2/envvars\'
	    sudo bash -c \'echo export DB_USERNAME="root" >> /etc/apache2/envvars\'
	    sudo bash -c \'echo export DB_NAME="auctionsystem" >> /etc/apache2/envvars\'
	    sudo bash -c \'echo export DB_PORT="3306" >> /etc/apache2/envvars\'


	    sudo service apache2 restart
	SHELL
end

