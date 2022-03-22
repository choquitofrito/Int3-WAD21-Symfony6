# Deploiement d'une app Symfony sur Heroku 


**1**. Installer le **client Heroku**
 
**https://devcenter.heroku.com/articles/heroku-cli#install-the-heroku-cli**

**2**. **Vérifier** l'installation (attention au PATH)

        heroku --version

**3**. **Faites login** dans une console

        heroku login -i

**4**. **Créez votre application** Symfony (sautez ce pas si vous en avez déjà votre app en local)

        symfony new --webapp monapp


**5**. **Allez dans le dossier de votre app et créez une application (vide) en Heroku (le "remote")** (vous allez faire push de votre local). Observez votre liste de remotes :

        heroku create -a monapp
        heroku git:remote -a monapp
        git remote -v 

Vous allez avoir deux remotes: un dans github et l'autre dans heroku (la version hebergée que vous allez mettre online)


**6**. Créez un fichier Procfile (sans extension) dans la racine de votre projet contenant ce code :

        web: heroku-php-apache2 public/

Ce fichier indique à Heroku d'utiliser Apache et cherche la page index.php dans le dossier **public** (la structure de Symfony)

**7**. Rajoutez le fichier au repo et faites **commit**
   
        git add Procfile
        git commit -m "Heroku Procfile"

**8**. Heroku utilise Apache. Installez 

```
composer require symfony/apache-pack
git add .
git commit -m "mod composer"
```
pour que Symfony gére le routing avec Apache


<br>

**9**. Par défaut, Symfony utilisera l'environnement **dev**. Pour changer ce comportement, lancez :

        heroku config:set APP_ENV=dev

ou 

        heroku config:set APP_ENV=prod


**10**. Rajoutez une BD PosgreSQL à votre projet.

Connectez-vous au site de Heroku, cliquez sur le nom de l'application, puis sur **Resources**

Dans **Add-ons**, tapez **Postgres** et cliquez sur **Heroku Postgres**.
Selectionnez et cliquez sur **Submit**.
Heroku fournit une BD Postgres gratuitement, mais pas de BD MySql.

Pour nous c'est transparent car c'est Doctrine qui crée le SQL selon le type de BD. Les bases de données ne sont pas pareilles (dans Postgres, par exemple, il n'y a pas d'Autonumber...) mais heureusement Doctrine gére tout ça pour nous!

**Il faut juste effacer les migrations créés en local (car les migrations créent du SQL pour MySql** avant de faire chaque push vers Heroku, car une migration créé avec la configuration de Mysql ne fonctionnera pas sur une bd Postgres (encore une fois, le fichier migration.bat nous convient...)

Cliquez sur **Heroku Postgres**, puis onglet **Settings** et **Database Credentials** et puis sur **View Credentials**. Ces crédentielles auront priorité sur nos fichiers de config (.env).

        Notes extra: 

        Si on veut connecter à cette BD depuis notre code local (au lieu de connecter à notre BD Mysql), on a qu'à copier la URI dans le fichier .env!

        Heroku ne fournit pas gratuitement un pannel style **phpmyadmin**. Si on veut voir le contenu de la BD il faudra installer un plugin de VSCode (facil). On aurait pu aussi avoir un serveur Postgres en local, mais ça depasse notre budget de temps :D

En local on peut toujours utiliser notre config de .env qui nous connectera à notre BD Mysql (locale)

<br>

**11**. Si vous allez pusher en **dev** vous devez deplacer les dependances de require-dev à require car elles seront utilisées par Heroku

Ouvrez composer.json. Deplacez les lignes de la section require-dev à la section require (require-dev reste vide)

Lancez:

```
composer update
git add composer.json
git add composer.lock
git commit -m "dep moved"
```


**12**. Avant de faire **le prémier** push, indiquez à heroku que notre projet est du PHP + Node. Il lancera webpack par lui-même

```
heroku buildpacks:add --index 1 heroku/php
heroku buildpacks:add --index 2 heroku/nodejs
```
(Vous pouvez aussi effacer les buildpacks avec buildpacks:remove)

**12**. Faites **push** à Heroku (pas à votre remote :D) !!
```
        git push heroku main
```

L'app sera deployée sur Heroku, qui essayera de faire la compilation. Il nous reste qu'à lancer les migrations et les fixtures.

**13**. Ouvrez un bash dans le serveur
```
heroku run bash
```
Lancez les migrations et les fixtures dans le serveur heroku (la BD est déjà créée). Effacez d'abord les migrations car elles peuvent avoir être crées en local (migrations mysql). Nous n'avons pas l'executable **symfony.exe**, alors on utilise **php bin/console** (dans de versions précédantes de Symfony cet executable n'existait même pas)
``` 
rm migrations/*
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console d:f:l
```

**IMPORTANT**

- Dans le ProjetCalendrier on a eu un problème car 'end' est un mot reservé du SQL de Postgres. Quand Doctrine crée le INSERT pour lancer les fixtures Postgres se plante.

**Solution facile pour de problèmes similaires**: provoquer que le nom de la colonne soit différent dans la BD en **rajoutant 'name' dans l'attribut de l'entité**:

```php
#[ORM\Column(type: 'date', nullable: true, name:'end_date')]
private $end;
```

**14**. Tapez l'url de l'app ou cliquez sur **open app** dans le menu de Heroku

