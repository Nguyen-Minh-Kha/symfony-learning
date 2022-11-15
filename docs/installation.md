# Installation

## Prerequisite

1. PHP (MAMP)
2. [Composer](https://getcomposer.org/doc/00-intro.md)
3. [Symfony CLI](https://symfony.com/download)
4. MySQL (MAMP)

## Create a new project

```
symfony new --webapp nameOfProject
```

## Clone a project

```
git clone https://url-du-projet-git.com
```

## Configure the project

Change variables in `.env` file

## Create database

```
symfony console doctrine:database:create
```

## Start server with symfony

```bash
symfony server:start
# custom port
symfony server:start --port=5656
```
