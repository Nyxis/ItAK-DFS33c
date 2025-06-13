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

## Organisation des dossiers et fichiers

```
main.php                  # fichier d'amorçage, permet de lancer l'application
data/                     # contient les données de l'application sous forme de fichiers
src/
|-- Application/          # contient les contrôleurs de l'application, le code spécifique pour amorcer
|-- |-- Application.php   # les traitements métiers
|-- |-- Controller/
|-- |-- Command/
|
|-- Infrastructure/       # contient les classes "techniques" qui permettent l'intéraction avec
|                         # le hardware de votre application / robot (fichiers, bases de données...)
|
|-- Lib/                  # contient des classes utilitaires au service du code
|
|-- Module/               # contient les modules métiers de votre application, le coeur du modèle
|-- |-- Character
|-- |-- Mj
|-- |-- ...
```

Cette structure permet de matérialiser physiquement l'architecture hexagonale (clean archi) : Application ---> Infrastructure ---> Module ---> Lib.
Clé de lecture : Si un fichier est contenu dans un dossier, il ne doit pas avoir de dépendance sur une classe situé dans un dossier précédent.

## Ajouter du code

Le projet défini un autoloader : chaque classe dans le dossier `src/` peut être appelée dans un autre fichier à condition d'inclure son namespace :
```php
use Chemin/De/La/Classe;     // à partir de src/

// ......
$objet = new Classe();
```

En fonction de la responsabilité de votre classe, vous l'ajouterez à tel ou tel dossier tel que décrit dans la section précédente.

