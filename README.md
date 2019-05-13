[![Build Status](https://travis-ci.org/albertborsos/yii2-realworld-example-app.svg?branch=master)](https://travis-ci.org/albertborsos/yii2-realworld-example-app)

# ![RealWorld Example App](logo.png)

> ### Yii 2.0 codebase containing real world examples (CRUD, auth, advanced patterns, etc) that adheres to the [RealWorld](https://github.com/gothinkster/realworld) spec and API.


### [Demo](https://github.com/gothinkster/realworld)&nbsp;&nbsp;&nbsp;&nbsp;[RealWorld](https://github.com/gothinkster/realworld)


This codebase was created to demonstrate a fully fledged fullstack application built with Yii 2.0 including CRUD operations, authentication, routing, pagination, and more.

We've gone to great lengths to adhere to the Yii 2.0 community styleguides & best practices.

For more information on how to this works with other frontends/backends, head over to the [RealWorld](https://github.com/gothinkster/realworld) repo.


# How it works

> Every conduit related classes are in the modules folder
> - modules/conduit - common/base classes
> - modules/api - api related classes and services

# Getting started

```
docker-compose up
docker exec -it yii2-realword-example-app_web_1 /bin/bash

composer install
./yii migrate
./yii conduit/seeder
```
