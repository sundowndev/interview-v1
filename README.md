# interview-v1

![](https://api.travis-ci.org/Sundowndev/interview-v1.svg?branch=master)

## Description

1/ Développer en PHP une mini API REST avec output en json

Cette api doit:

 - Gérer 2 types d'objets:
    User (id, name, email)
    Task (id, user_id, title, description, creation_date, status)

 - Mettre à disposition des endpoints permettant de récupérer les données d'un user et d'une task. (ex: /user/$id)

 - L'api doit être capable de manipuler la liste des taches associées à un utilisateur en offrant la possibilité de:
    Récupérer cette liste de taches
    Créer et ajouter une nouvelle tache
    Supprimer une tache

En développant cette API, vous devez garder en tête qu'elle est susceptible d'évoluer (nouveaux retours, nouveaux attributs dans les objets)

2/ Développer un front en HtML/JS/CSS (pas de design nécessaire)

Ce front doit communiquer avec l'api en ajax.
On doit pouvoir ajouter/supprimer un utilisateur
Gérer la liste des tâches d'un utilisateur (liste / ajout / suppression)

(pas de framework)

## Installation and usage

```bash
$ git clone git@github.com:Sundowndev/interview-v1.git
$ cd interview-v1/
$ docker-compose up -d
```

You can now browse the front app at `localhost:3000` and the API at `localhost:8000`.

## Architecture

## Database

## Security

## API endpoints
