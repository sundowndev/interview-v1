# interview-v1

Build status : ![](https://api.travis-ci.org/Sundowndev/interview-v1.svg)

## Description

1/ Develop a mini PHP REST API with json output

This api must manage 2 objects :
- User (id, name, email)
- Task (id, user_id, title, description, creation_date, status)

Create API endpoints to recover a user or task data. (e.g /user/{id})

L'api doit être capable de manipuler la liste des taches associées à un utilisateur en offrant la possibilité de:
- Fetch the latest tasks
- Create a task
- Delete a task

En développant cette API, vous devez garder en tête qu'elle est susceptible d'évoluer (nouveaux retours, nouveaux attributs dans les objets)

2/ Create a frontend client to call the API

- The client must call the api using ajax
- We must be able to create/delete an user
- Manage user's tasks (read / add / delete)

(no framework)

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

To handle authentication feature, we use a CSRF and a http-only session cookie.

As soon as the user provide valid credentials, we return a two tokens that will be needed for each request he will send to the API.

For each request, the user send the CSRF token as GET/POST/DELETE/PUT parameter. The cookie is sent automatically.

**Technical user story:** the user provide an username and password as POST parameter to /auth route. The credentials are checked in the database and if it's valid it returns a CSRF token and a token for the session cookie. The session is also stored in the database so at every client request, both tokens are checked and we can also identify the user through his tokens.

## API endpoints

| Method / Route        | Resource           | Description  |
| --------------------- | ------------------ | ------------ |
| `POST` /auth      | Authentication | Connect and get an api key |
| `GET` /tasks      | Task      |   Get latest taks |
| `GET` /tasks/{id} | Task      |    Get a task by given id |
| `POST` /tasks | Task      |    Create a task |
| `PUT` /tasks/{id} | Task      |    Update a task by given id |
| `DELETE` /tasks/{id} | Task      |    Delete a task by given id |
| `GET` /me | Users      |    Get your own account data |
| `GET` /users/{id}/tasks | Users,Tasks      |    Get tasks from a given user id |
