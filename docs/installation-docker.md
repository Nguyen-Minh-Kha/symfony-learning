# Instalation with docker

This project has docker integration

1. Clone project `git clone https://url.com`
2. Copy .env.example as .env
3. Choose your $PORT and if you want Stripe integration please use your Developper API keys
4. Start containers `bin/start`

## Note

With docker, if we use symfony console, it will use the php installed on your machine.

To use symfony installed with docker, you need to use the following command:

```
bin/sf <command>
```

## Load fixtures for testing purposes

```
bin/sf console h:f:l
```
please also check the [data](../fixtures/data.yml) to know how to connect as Admin

## Stop app

```
bin/stop
```

Check [Docker docs](./note-docker.md) for more infos.