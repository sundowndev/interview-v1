# interview-v1

![](https://api.travis-ci.org/Sundowndev/interview-v1.svg)

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

The architecture is made of a simple client -> server communication using Docker containers.

<p align="center">
 <img src="https://i.imgur.com/9EG2rso.png" alt="">
</p>

## Database

## Security

## API endpoints

| Method / Route        | Resource           | Description  |
| --------------------- | ------------------ | ------------ |
| `POST` /auth      | Authentification | Connect and get an api key |
| `GET` /tasks      | Task      |   Get latest taks |
| `GET` /tasks/{id} | Task      |    Get a task by given id |
| `POST` /tasks | Task      |    Create a task |
| `PUT` /tasks/{id} | Task      |    Update a task by given id |
| `DELETE` /tasks/{id} | Task      |    Delete a task by given id |
| `GET` /me | Users      |    Get your own account data |
| `GET` /users/{id}/tasks | Users,Tasks      |    Get tasks from a given user id |
