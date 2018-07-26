# interview-v1

Build status : ![](https://api.travis-ci.org/Sundowndev/interview-v1.svg)

## Description

1/ Develop a mini PHP REST API with json output

This api must manage 2 objects :
- User (id, name, email)
- Task (id, user_id, title, description, creation_date, status)

Create API endpoints to recover a user or task data. (e.g /user/{id})

The API must be able to manage users tasks and create the endpoints to:
- Fetch the latest tasks
- Create a task
- Delete a task

While developing this API, you must keep in mind it can evolve at any moment (new resources, new properties in objects ...).

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

To handle authentication feature, we use JWT authentication.

JSON Web Token (JWT) is an open standard ([RFC 7519](https://tools.ietf.org/html/rfc7519)) that defines a compact and self-contained way for securely transmitting information between parties as a JSON object. This information can be verified and trusted because it is digitally signed. JWTs can be signed using a secret (with the HMAC algorithm) or a public/private key pair using RSA or ECDSA. [Source](https://jwt.io/introduction/)

As soon as the user provide valid credentials, we return a JWT token that will be needed for each request the client will send to the API.

For each request, the user send the JWT token as parameter.

![JWT explained](https://cdn-images-1.medium.com/max/1400/1*SSXUQJ1dWjiUrDoKaaiGLA.png)

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
