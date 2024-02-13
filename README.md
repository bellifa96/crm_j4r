CRM J4R 
========================

The "Symfony Demo Application" is a reference application created to show how
to develop applications following the [Symfony Best Practices][1].


L'application que nous avons développée repose sur une architecture à trois niveaux, également connue sous le nom d'architecture trois tiers. Ce modèle est composé de trois couches distinctes : la couche d'accès aux données (DAO), la couche métier (Business), et la couche de présentation. La couche DAO est responsable de l'accès aux données et de la manipulation de celles-ci au sein de la base de données. Elle offre une interface pour exécuter des requêtes et des opérations sur les données, tout en maintenant la séparation entre la logique métier et la logique d'accès aux données. La couche métier contient la logique métier de l'application. Elle traite les règles métier, effectue les calculs nécessaires et coordonne les interactions entre les différentes entités de l'application. Enfin, la couche de présentation est chargée de l'interface utilisateur. Elle gère l'affichage des données à l'utilisateur final et reçoit les entrées de celui-ci

Requirements
------------

  * PHP 8.2.0 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][2].

Lancer Application
------------

**Etape 1.** [Compiler les ressources ][4] on a utilisé `webpack encore`
on your computer to run this command:

```bash

$ npm encore dev

```

**Etape 2.** [Download Composer][6] and use the `composer` 
La commande composer init est utilisée pour créer un fichier composer.json qui est le fichier de configuration principal pour un projet PHP géré par Composer. Voici comment vous pouvez utiliser cette commande :

```bash
# you can create a new project based on the Symfony Demo project...
$ composer init



```


Usage
-----

There's no need to configure anything before running the application. There are
2 different ways of running this application depending on your needs:

**Option 1.** [Download Symfony CLI][4] and run this command:

```bash
$ cd my_project/
$ symfony server:start  
```


