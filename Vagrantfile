# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  # https://docs.vagrantup.com : Documentation.

  # The one we used in the labs suits my use well
  config.vm.box = "ubuntu/xenial64"

  config.vm.define "frontendwebserver" do |frontendwebserver|
    frontendwebserver.vm.hostname = "frontendwebserver"
    frontendwebserver.vm.network "forwarded_port", guest: 80, host: 10222, host_ip: "127.0.0.1"
    frontendwebserver.vm.network "private_network", ip: "192.168.33.10"
	
	frontendwebserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]
    
	frontendwebserver.vm.provision "shell", inline: <<-SHELL
      apt-get update
      # My frontend will run on php and will write data to a mysql server
      apt-get install -y apache2 php libapache2-mod-php php-mysql
	  
	  # Change VM's webserver's configuration to use shared folder.
      # (Look inside test-website.conf for specifics.)
      cp /vagrant/test-website.conf /etc/apache2/sites-available/
      # install our website configuration and disable the default
      a2ensite test-website
      a2dissite 000-default
      service apache2 reload
    SHELL
  end
	
  config.vm.define "databaseserver" do |databaseserver|
	databaseserver.vm.hostname = "databaseserver"
	databaseserver.vm.network "private_network", ip: "192.168.33.14"
	databaseserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", mount_options: ["dmode=775,fmode=777"]
	
	databaseserver.vm.provision "shell", inline: <<-SHELL
		apt-get update
		export MYSQL_PWD='AlexanderRoot'
		
		echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections 
		echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections

		apt-get -y install mysql-server
		
		echo "CREATE DATABASE fvision;" | mysql
		echo "CREATE USER 'webuser'@'%' IDENTIFIED BY 'Alexander';" | mysql
		echo "GRANT ALL PRIVILEGES ON fvision.* TO 'webuser'@'%'" | mysql
		
		export MYSQL_PWD='Alexander'
		cat /vagrant/setup-db.sql | mysql -u webuser fvision
		sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf
		service mysql restart
	SHELL
  end
		
end
