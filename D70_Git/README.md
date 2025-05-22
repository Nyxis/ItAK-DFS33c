# D70 - Git / Github / systèmes de versioning

## Apprentissage des commandes usuelles

Effectuez les exercices des 4 premières parties de l'onglet "Principal" du sandbox Git https://learngitbranching.js.org/?locale=fr_FR.

Effectuez ensuite les exercices de la partie "Remote".

## Setup propre de Git sur une machine

Dans cet exercice, nous allons mettre en place des bonnes pratiques pour utiliser Git et Github, et plus généralement travailler rigoureusement.

### Mettre à jour vos paquets et librairies

En développement, nous utilisons beaucoup de petits programmes et logiciels pour nous simplifier le travail. Seulement, vu qu'ils sont pour la plupart open-source, les mises à jour sont régulières et importantes et comblent pour la plupart des failles de sécurité : il est donc nécessaire de les maintenir à jour.

Chaque système propose son gestionnaire de paquets, et nous allons les utiliser pour installer Git.

**MacOS**
[Homebrew](https://brew.sh/)

```bash
# assure que Git est bien dans la dernière version
brew update; brew reinstall git
```

**Linux (Ubuntu)**
[Apt-get](https://doc.ubuntu-fr.org/apt)

```bash
sudo apt-get update
sudo apt-get upgrade git
# si pas installé
sudo apt-get install git
```

**Windows**
[WinGet](https://learn.microsoft.com/fr-fr/windows/package-manager/winget/) via Windows Powershell

```powershell
winget install --id Git.Git -e
```

### Créez un espace de travail

Choisissez un dossier racine pour vos projets; `~/Workspace/IT-Akademy` est conseillé.
Dans ce dossier, créez les dossiers `.git` et `.ssh`.

### Sécurisation des accès aux dépots distants via SSH

Git implémente le [protocole SSH](https://www.ssh.com/academy/ssh/openssh#ssh-key-management) pour sécuriser ses échanges interserveurs.
Une bonne pratique consiste à utiliser des clés SSH différentes en fonction des contextes afin d'éviter de multiplier les vulnérabilités en cas de fuite de données. Elle permettra également d'avoir des configurations différentes en fonction des projets sans risque de surcharges.

Pour aller plus loin sur le chiffrage à double clés : https://youtu.be/_YNQcA_qzJ0; pour aller encore plus loin sur la cryptographie :
https://youtu.be/NJT4g5gu50c?t=500&si=pb8jTOdRcXy7n6pw.

Pour tous les cas pratiques, nous allons utiliser un serveur Github pour publier notre code, il faudra sécuriser ces échanges via une paire de clés.

Générons nos clés pour commencer :
**MacOs / Linux**

```bash
cd <votre workspace>

brew install openssh
# ou
sudo apt update
sudo apt install openssh-client

ssh-keygen -t rsa -b 4096 -C "<votre_email@it-students.fr>" -f ./.ssh/it_akademy_rsa
```

**Windows**

```powershell
cd <votre workspace>
winget install --id Microsoft.OpenSSH.Client -e
ssh-keygen -t rsa -b 4096 -C "<votre_email@it-students.fr>" -f ".ssh\it_akademy_rsa"
```

Vous pouvez sécuriser votre clé via une passphrase, ce qui est fortement conseillé si votre clé est utilisée pour accéder à une plateforme de production ou à des informations critiques sur votre production (mots de passe, adresses ip / ports, ...).

Pour vérifier que vos clés sont installées, vous pouvez lister le contenu du dossier `.ssh` :

```bash
ls -al .ssh
```

### Travailler à partir d'un dépôt en lecture seule

Pour tous les travaux pratiques à venir, nous allons utiliser ce dépôt Github pour centraliser la remise des devoirs.

Vous ne disposerez cependant pas des droits en écriture sur ce dépôt comme c'est souvent le cas, en particulier quand on travaille en Open Source. Vos modifications passeront par des "propositions de modifications", via la mécanique de "fork" de Github, qui permet de faire une copie d'un dépôt vers votre espace personnel pour implémenter vos fonctionnalités sans impacter le dépôt original.

Pour commencer, créer votre compte sur Github avec votre adresse @it-students.
Pour sécuriser vos échanges avec les serveurs Github, nous allons y référencer votre clé publique, générée précédemment. Dans votre profil (Settings / SSH & GPG keys), ajoutez le contenu de la clé publique (`cat <votre workspace>/.ssh/it_akademy_rsa.pub`).

Rendez-vous à la racine du projet : https://github.com/Nyxis/ItAK-DFS33c; puis suivez les étapes 1 & 2 de la documentation "[livrez votre travail](../docs/workflow.md)".

Vous disposez maintenant d'un dépôt local capable d'échanger avec votre fork. Pour pouvoir publier des modifications dessus, vous devez néanmoins authentifier vos appels les configurations de votre dépôt.
Votre authentification passera par 3 configurations : Nom, Email et clé privée.

Pour les référencer, éditez le fichier `.git/config`, pour y ajouter les 3 configurations suivantes :

```config
[core]
    # .....
    sshCommand = "ssh -i ../.ssh/it_akademy_rsa"
    # .....
[user]
    name = <Prenom> <Nom>
    email = <p.nom>@it-students.fr
```

Vous pouvez également exécuter ces 3 commandes, si vous souhaitez automatiser le processus de configuration de votre dépôt :

```bash
git config user.name "Prénom Nom"
git config user.email "p.nom@it-students.fr"
git config core.sshCommand "ssh -i ../.ssh/it_akademy_rsa"
```

Pour valider que vos configurations sont bien référencées, vous pouvez utiliser la commande `git config --list --show-origin`.

Testez que vos configurations sont correctes via `git fetch -a -p`.

### Votre premier commit

Effectuez l'étape 3 de la documentation "[livrez votre travail](../docs/workflow.md)".
Votre copie est maintenant à jour à partir du dépôt principal.

Ajoutez l'image `pedro_panic.webp` ci-dessous :
![pas Pedro :(](./anne.webp)

Effectuez l'étape 4 puis 5 de la documentation "[livrez votre travail](../docs/workflow.md)".

### Et votre premier conflit

Dans le cas où quelqu'un d'autre modifie le même segment de fichier, il est possible que Git ne puisse pas utiliser ses algorithmes de merge.

Dans ce cas, il s'arrête en mode "detached HEAD" et propose de le gérer à la main.

Récupérez la branche `merge_me` dans votre dépôt local et effectuez un `git merge` dans votre branche de travail.

Un conflit va aparaître, résolvez le en fonction de vos goûts puis publiez le résultat dans votre branche de travail.

**Tips** : `merge`, `pull`, `commit`, `fetch`

Recommencez avec la branche `rebase_me`, mais en utilisant cette fois `git rebase` dans votre branche de travail.
Attention, dans le cas d'un rebase, la commande de résolution ne sera pas la même.

## En cas réel

Reprenez le code Php produit dans le module AD24.
Livrez le dans ce dépôt en respectant la procédure "[livrez votre travail](../docs/workflow.md)", dans le dossier correspondant.

Recommencez avec le code Javascript produit dans le module D2.

Vous veillerez à bien ouvrir des Pull Requests différentes pour chaque module, et de ne pas mélanger le code des différents modules dans une branche.
