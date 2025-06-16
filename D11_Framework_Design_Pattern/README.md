# Php / Framework / Design Patterns

Dans ce module, nous allons approfondir les notions vues dans le module D11.
Assurez vous que ces exercices soient terminés avant de passer aux suivants.

## Design Pattern

Les Design Patterns ont été conçus pour permettre un découplage plus efficace des différents éléments de code, des classes en particulier.
Récupérez la dernière version du code pour partir sur une base saine.

### Stratégie & Visiteur

Précédemment, nous avons vu l'Adapter via une abstraction des sources de persistence. Nous allons reprendre ce système pour permettre à l'Adapteur fichier de sélectionner la stratégie optimale en fonction du type de fichier.

Modifiez votre code pour que votre adapteur Json devienne un adapteur fichier, qui ai une dépendance sur un comportement précis.
Implémentez donc ces deux classes, suffixez les si vous le souhaitez :
 - JsonFileDatastoreAdapter > FileDatastore *(Adapter)*
 - FileReader *(Interface)*
 - JsonFileReader implements FileReader

Modifiez le code de votre Application afin qu'elle utilise ces classes :
```php
// project/JdR/src/Application/Application.php
public function run(array $argv)
{
    $factory = new ScenarioFactory(
        new FileDatasource(
            new File(/* chemin/vers/le/fichier.json */) // @see Application::dataDir
            new JsonFileReader()
        )
    );
}
```
Nous venons de créer une stratégie de lecture du fichier en paramètre. La mécanique est proche de l'Adapter, mais est orientée fonctionnelle plus que structurelle : le JsonFileReader n'a pas connaissance de l'objet File avant son utilisation, il n'est pas été créé spécifiquement pour lui.

En l'état, notre FileDatastore ne lit que du JSON, il serait nécessaire de savoir à l'avance le format du fichier source pour injecter la bonne stratégie de lecture au FileDatasource.

Pour éviter ce problème et garantir une meilleure flexibilité, nous allons créer un visiteur.

Commencez par ajouter une méthode `accepts(File $file) : bool` dans l'interface FileReader. Implémentez-la dans JsonFileReader : elle devra renvoyer vrai si le fichier est un json.

Modifiez ensuite FileDatasource pour qu'il prenne en paramètre non pas un FileReader mais un tableau.
Implémentez ensuite l'algorithme de visite à la place du simple `readfile` :
```
pour chaque FileReader:
    si accepts(File) renvoie vrai:
        return fonction décode sur le File

si aucun driver n'a accepté:
    lancer une erreur
```

Vous venez de coder votre Visiteur.
Créez maintenant une stratégie pour lire un fichier .csv et ajoutez la à votre FileDatasource.

Ecrivez un rapide code pour afficher le contenu de `equipement.csv`.

### Command

Introduction aux Actions, Routing & Controllers.
