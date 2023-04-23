# Locauto backend

## Installation

### Installation avec Docker

Assurez-vous d'avoir Docker installé sur votre machine.

#### 1. Clonez le dépôt du projet en utilisant la commande

```bash
git clone https://github.com/Nayzow/locauto
```

#### 2. À la racine du projet, Construisez l'image Docker à partir du fichier Dockerfile en utilisant la commande

```bash
docker build -t locauto-backend .
```

#### 3. Exécutez le conteneur en utilisant la commande

```bash
docker run --name locauto-backend -p 80:80 -d locauto-backend
```

L'application devrait maintenant être accessible à l'adresse http://localhost:80/ à l'aide d'un serveur nginx.