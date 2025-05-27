# Php / Design Patterns

Pour cette suite d'exercices, récupérez le corrigé du module AD24 dans la branche `main` du dépôt.
Pour installer et lancez le projet, suivez le [documentation](../projects/JdR/) présente dans le dossier.

## Principes SOLID

### Application du principe Open / Closed

Le principe Open / Closed stipule qu'un objet doit gérer lui-même ses changements d'états, sans le déléguer à une classes externe.

<table>
<tr>
<th>Exemple :</th>
<th>Devient : </th>
</tr>
<tr>
<td>
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
</td>
<td>
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
</td>
</tr>
</table>

Complétez la classe Character pour intégrer la gestion de l'équipement et du niveau; un personnage pour s'équiper d'un Equipement et monter de niveau.
Implémentez enfin une représentation de la puissance personnage : puissance = niveau + nb d'équipement - 1 pour chaque 2 blessures.

Ajoutez une nouvelle règle : à chaque montée en niveau, le maximum de points de vie augmente de 1, et le personnage est soigné de 1.

## Design Patterns

### Factory

Pour commencer à utiliser des Factories, nous allons créer nos objets depuis un fichier au format JSON. Vous vous forcerez à respecter les normes et conventions du projet.

Dans le fichier d'application, créez un objet qui permet de lire le fichier `data/scenarios.json`.

__Tips__ : `file_get_contents`, `json_decode`, `json_validate`.

Grâce aux données reçues, initialisez des objets `Module\Scenario\Scenario`, `Module\ScenarioEncounter` et `Module\Scenario\Result` à partir des données du fichier .json et renvoyez le objets Scenario sous forme de tableau.

Vous venez de créer votre première **Factory**, une classe dont la responsabilité est de créer des objets.



