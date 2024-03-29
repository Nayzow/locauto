# Locauto

## Description

Web app de gestion de locations de véhicules dans un garage réalisée en HTML, CSS, JS, Bootstrap pour le frontend
et PHP pour le backend avec une base de donnée MYSQL.

## Presentation

![presentation.gif](resources%2Fpresentation.gif)

## Documentation

### Backend :
- PHP
- Github : https://github.com/Nayzow/locauto/tree/main/backend
- Docker Hub : https://hub.docker.com/r/nayzow/locauto-backend

### Database :
- MySQL
- Github : https://github.com/Nayzow/locauto/tree/main/database
- Docker Hub : https://hub.docker.com/r/nayzow/locauto-database

## Déploiement

Le déploiement est configuré pour tourner en local. Pour déployer le projet, il suffit de récupérer le fichier "docker-compose.yaml" avec le code ci-dessous :

```yaml
version: '3'
services:
  database:
    image: nayzow/locauto-database
    ports:
      - "3306:3306"

  backend:
    image: nayzow/locauto-backend
    ports:
      - "80:80"
    depends_on:
      - database
    restart: always
```
Lien du fichier de déploiement : https://github.com/Nayzow/locauto/blob/main/docker-compose.yaml

Et ensuite d'effectuer cette commande dans le répertoire courant du fichier "docker-compose.yaml" :

```bash
docker-compose up
```

L'application Web est désormais disponible à l'adresse http://localhost