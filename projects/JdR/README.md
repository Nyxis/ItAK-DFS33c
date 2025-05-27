# Projet JdR

Projet "fil rouge" de la session : un MJ anime une session de jeu de rôles pour un groupe d'aventuriers.

## Installation

```sh
git pull --rebase prof main
```

## Lancement

```sh
# à la racine du dépôt
php projects/JdR/main.php
# ou
docker run --rm -it -v "$(pwd)/projects/JdR":/app -w /app php:8.4-cli-alpine php main.php
```

## Conventions

Principes [SOLID](https://medium.com/@abderrahmane.roumane.ext/tout-comprendre-des-principes-solid-en-10-minutes-votre-guide-rapide-pour-un-code-plus-efficace-bc625c3634f5).
Application des [PSR](https://www.php-fig.org/psr/).
Workflow de livraison : [documentation](../../docs/workflow.md).
