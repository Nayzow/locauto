# Locauto database

Base de donnée MySql pour stocker les données du projet. La base de données contient des véhicules liés à des catégories et des marques, ainsi que des locations de véhicules.

## Informations

Le script SQL pour la création de la base de donnée se situe dans le dossier resources.

```
database : locauto
login : root
password : test
```

## Installation

#### 1. Build l'image

```bash
docker build -t locauto-database .
```

#### 2. Lancer le container à partir de l'image

```bash
docker run --name locauto-database -p 3306:3306 -d locauto-database
```

## UML

![uml.png](resources%2Fuml.png)