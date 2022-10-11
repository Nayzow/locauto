# Locauto
## Présentation
Web App en PHP/HTML/CSS/JS/Bootstrap pour la gestion de locations de véhicules dans un garage avec une base de données MySQL.

## README
Le script sql de la base de données ainsi que le cahier des charges se trouvent dans le dossier ressources.

Le css, le javascript ainsi que les images se trouvent également dans le dossier ressources.

L'ensemble du code source php se trouve dans le dossier src.

Le fichier .htaccess sert à définir des régles de redirection de page pour le serveur apache.

Le fichier de configuration php se trouve ici : /config/php.ini

## Base de donnée
#### Connexion base de données -> le fichier se trouve ici : /src/DbConnexion.php
```php
    DB_HOST = 'localhost';
    DB_NAME = 'locauto';
    DB_USER = 'root';
    DB_PASSWORD = '';
```