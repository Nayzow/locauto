sudo apt-get update
sudo apt install apache2 -y
sudo apt install mysql -y
sudo apt install php -y
sudo cd /var/www/html/
sudo rm index.html
sudo wget https://github.com/Nayzow/Locauto.git
sudo cd Locauto
sudo cp . ..
sudo cd ..
sudo rm -r Locauto
sudo mysql -u root -p < /var/www/html/ressources/sql/database.sql