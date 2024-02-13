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

There are 3 different ways of installing this project depending on your needs:

**Etape 1.** [Download Symfony CLI][4] and use the `symfony` binary installed
on your computer to run this command:

```bash
$ symfony new --demo my_project
```

**Option 2.** [Download Composer][6] and use the `composer` binary installed
on your computer to run these commands:

```bash
# you can create a new project based on the Symfony Demo project...
$ composer create-project symfony/symfony-demo my_project

# ...or you can clone the code repository and install its dependencies
$ git clone https://github.com/symfony/demo.git my_project
$ cd my_project/
$ composer install
```

**Option 3.** Click the following button to deploy this project on Platform.sh,
the official Symfony PaaS, so you can try it without installing anything locally:

<p align="center">
<a href="https://console.platform.sh/projects/create-project?template=https://raw.githubusercontent.com/symfonycorp/platformsh-symfony-template-metadata/main/symfony-demo.template.yaml&utm_content=symfonycorp&utm_source=github&utm_medium=button&utm_campaign=deploy_on_platform"><img src="https://platform.sh/images/deploy/lg-blue.svg" alt="Deploy on Platform.sh" width="180px" /></a>
</p>

Usage
-----

There's no need to configure anything before running the application. There are
2 different ways of running this application depending on your needs:

**Option 1.** [Download Symfony CLI][4] and run this command:

```bash
$ cd my_project/
$ symfony server:start  
```


Tests
-----

Execute this command to run tests:

```bash
$ cd my_project/
$ ./bin/phpunit
```

[1]: https://symfony.com/doc/current/best_practices.html
[2]: https://symfony.com/doc/current/setup.html#technical-requirements
[3]: https://symfony.com/doc/current/setup/web_server_configuration.html
[4]: https://symfony.com/download
[5]: https://symfony.com/book
[6]: https://getcomposer.org/