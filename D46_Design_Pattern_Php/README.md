# Php / Design Patterns

Pour cette suite d'exercices, récupérez le corrigé du module AD24 dans la branche `main` du dépôt.
Pour installer et lancez le projet, suivez la [documentation](../projects/JdR/) présente dans le dossier.

## Principes SOLID

### Application du principe Open / Closed

Le principe Open / Closed stipule qu'un objet doit gérer lui-même ses changements d'états, sans le déléguer à une classes externe.

Exemple :
```php
class Character
{
    private int $currentHealth;

    public function __construct(
        private int $maxHealth
    ) {
        $this->setCurrentHealth($this->maxHealth);
    }

    public function getCurrentHealth() : int
    {
        return $this->currentHealth;
    }

    public function setCurrentHealth(int $currentHealth) : void
    {
        if ($currentHealth > $maxHealth) {
            throw new \InvalidArgumentException('Cant set a health value bigger than Character max health.');
        }

        $this->currentHealth = $currentHealth;
    }
}
```
Devient :
```php
class Character
{
    private int $currentHealth;

    public function __construct(
        private int $maxHealth
    ) {
        $currentHealth = $this->maxHealth;
    }

    public function isAlive() : bool
    {
        return $this->currentHealth > 0;
    }

    public function heal(int $amount = 1) : void
    {
        $this->currentHealth = min(
            $this->maxHealth,
            $this->currentHealth + $amount
        );
    }

    public function hurt(int $amount = 1) : void
    {
        $this->currentHealth = max(
            0,
            $this->currentHealth - $amount
        );
    }
}
```

Complétez la classe Character pour intégrer la gestion de l'équipement et du niveau; un personnage peut :
 - s'équiper d'un ou plusieurs Equipements
 - gagner des niveaux.

À chaque gain de niveau, le maximum de points de vie augmente de 1, et le personnage est soigné de 1.

Implémentez enfin une représentation de la puissance personnage en la calculant comme suit : 
`puissance = niveau + nb d'équipement - 1 pour chaque 2 points de vie manquants`

## Design Patterns

### Factory

Pour commencer à utiliser des Factories, nous allons créer nos objets depuis un fichier au format JSON. Vous vous forcerez à respecter les normes et conventions du projet.

Dans le projet, complétez la classe ScenarioFactory pour lire et extraire les données du fichier `data/scenarios.json`.

__Tips__ : `file_get_contents`, `json_decode`, `json_validate`.

Grâce aux données reçues, initialisez des objets `Module\Scenario\Scenario`, `Module\ScenarioEncounter` et `Module\Scenario\Result` à partir des données du fichier .json et renvoyez le objets Scenario sous forme de tableau.

Vous venez de créer votre première **Factory**, une classe dont la responsabilité est de créer des objets à partir de données non structurées.

### Adapter

Il apparaît que le principe de Responsabilité Unique n'est pas respecté pour la factory ainsi créée : elle doit pouvoir simplement lire une source de données, et de produire des objets à partir de ces données. Avoir une dépendance à des traitements de fichier JSON n'est pas dans ses responsabilités.

Pour commencer, découpez votre Factory en deux classes :
  - JsonFileReader : lit et décode un fichier .json
  - ScenarioFactory : lit un tableau de données fourni par la classe JsonFileReader

Pour tester la structure, modifiez le fichier d'amorçage avec le code suivant :
```php
public function run(array $argv)
{
    $factory = new ScenarioFactory(
        new JsonFileReader(/* chemin/vers/le/fichier.json */)
    );

    $scenarios = $factory->createScenarios();

    foreach ($scenarios as $scenario) {
        echo ($success = $this->mj->entertain(
            new Character(       // <-- votre classe Character
                /* vos attributs */
            ),
            $scenario
        ))
            ? "\n>>> 🤘 Victory 🤘 <<<\n\n"
            : "\n>>> 💀 Defeat 💀 <<<\n\n"
        ;
    }
}
```

Afin de découpler totalement la logique "fichier" de la construction du point de vue la Factory, nous allons introduire une interface intermédiaire, Datastore. Comme il s'agit d'une classe utilitaire et "agnostique" vis à vis du modèle et du hardware, nous allons l'ajouter du dossier `src/Lib`.
Ajoutez lui une méthode `public function loadData() : array`.

Modifiez maintenant la factory pour utiliser cette interface et non directement la classe JsonFileReader, en appelant la méthode `loadData()` de cette interface pour générer vos objets.

Pour permettre d'utiliser JsonFileReader dans la factory, il faut donc lui ajouter l'interface Datastore. Adapter le code pour que la méthode `loadData()` renvoie le contenu du fichier.

Ce résultat est satisfaisant d'un point de vue découplage, néanmoins, le principe de Responsabilité Unique c'est toujours pas respecté pour la classe JsonFileReader. Il possède maintenant les responsabilités :
- de lire un fichier
- de valider et convertir une chaine json en tableau
- de "store" des données (via Datastore) : on comprend aisément que les données vont rester stockées en mémoire une fois le fichier chargé, les appels fichiers étant très coûteux en ressources

Nous allons donc créer une classe intermédiaire entre la factory et le lecteur de fichier pour charger les données à la demande, et les stocker localement.
Créez la classe JsonFileDatastoreAdapter, qui implémente l'interface Datastore, et requiert JsonFileReader. Implémentez maintenant le comportement de chargement unique à la demande.

Votre fichier principal doit maintenant refléter les changements :
```php
public function run(array $argv)
{
    $factory = new ScenarioFactory(
        new JsonFileDatastoreAdapter(
            new JsonFileReader(/* chemin/vers/le/fichier.json */)
        )
    );

    // .......
}
```

La structure de l'appel reflète donc maintenant la réalité d'un Adapter : une classe entre deux autres sur le papier incompatible.

__Exercice bonus :__
Pour vous entrainer à utiliser des Value Objects, utilisez la classe Lib\File dans votre code.
Vous pouvez également créer une interface StructuredFile qui implémente la méthode `public parse() : array`, qui renvoie les données structurées et utiliser cette méthode dans votre adapter.
On peut également imaginer une FileFactory qui analyse le chemin de fichier donné en entrée pour créer un fichier structuré du bon type, comme par exemple un objet JsonFile (qui implémente StructuredFile) si me chemin termine par `.json`.

__Tips :__ `SplFileInfo`
