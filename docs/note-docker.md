# Symfony with docker

## create new project

```
bin/sf new --webapp my_project
```

## start server

```
bin/sf server:start
```

## stop server

```
bin/sf server:stop
```

## create database

```
bin/sf console do:da:cr
```

## make controller

```
bin/sf console ma:con <name of controller>
```

## make entity / repository

```
bin/sf console ma:en <name of entity>
```

## update db

```
bin/sf console do:sc:up --force
```

## create FormType

```
bin/sf console ma:fo <name of form type>
```

## create & run migration file

```
bin/sf console ma:mi 

bin/sf console do:mi:mi 
```
## check migration diff

```
bin/sf console do:mi:diff
```

## fixtures load 

```
bin/sf console h:f:l
```
