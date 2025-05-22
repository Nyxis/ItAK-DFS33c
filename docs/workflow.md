# Livrer son travail

1/ Effectuez un fork de ce dépôt en utilisant votre compte @it-students :
- Fork ⏷
- Create a new fork
Vous disposez maintenant de votre propre dépôt dans lequel vous pouvez déposer tout votre code. Veillez à laisser votre dépôt public.

2/ Clonez votre dépôt sur votre machine via HTTPS.
- <> Code ⏷
- HTTPS
- Copiez l'adresse https://github.com/........./ItAK-DFS.....git)

```shell
git clone -b main <url copiée> <nom dossier à créer>
cd <nom dossier à créer>
git remote add prof git@github.com:Nyxis/ItAK-DFS<votre numéro de session>.git
```

Cloner votre dépôt via HTTPS présente un défaut : votre mot de passe est prompt à chaque push, ce qui n'est ni ergonomique ni sécurisant; Github a même déprécié cette authentification.

Pour passer à SSH, nous allons mettre à jour le remote. Retrouvez l'adresse SSH, elle ressemble à `git@github.com:......../ItAK-DFS........git`). Lancez ensuite :
```shell
git remote set-url origin <url copiée>
```

3/ Effectuez les exercices du module dans une branche créée à partir du main du dépôt principal
```shell
# création de la branche
git branch module_Dxx prof/main
git checkout module_Dxx

Pour passer à SSH, nous allons mettre à jour le remote. Retrouvez l'adresse SSH, elle ressemble à `git@github.com:......../ItAK-DFS........git`). Lancez ensuite :
```shell
git remote set-url origin <url copiée>
```

3/ Créez une branche pour votre module à partir de la branche main du dépôt principal :
```shell
# mise à jour du dépot local
git fetch prof

# création de la branche
git branch module_<numéro module> prof/main
git checkout module_<numéro module>

# intégration de la version à jour
git pull --rebase prof main
    # résolvez les éventuels conflits
    git add <fichiers de conflits résolus>
    git rebase --continue
git push origin module_<numéro module> --force
```

4/ Effectuez les exercices du module puis créez un commit avec vos modifications, et publiez le dans votre dépôt.
```shell
git add <vos fichiers modifiés>
git commit -m "<message de commit>"
git push origin module_<numéro module>
```

5/ Dans votre dépôt, créez une Pull Request à partir de la branche que vous venez de déposer
- Pull Requests
- New Pull Request
- "compare accross forks"
- Base repository : `Nyxis/ItAK-DFS<votre numéro de session>` / base : `main` / head repository : `<votre fork>` / compare : `module_<numéro module>`
- Create pull request
- Title : `<Nom> <Prenom> - <numéro module>`
