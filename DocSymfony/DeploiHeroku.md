# Deploiement d'une app Symfony sur Heroku 


**1**. Installer le **client Heroku**
 
    **https://devcenter.heroku.com/articles/heroku-cli#install-the-heroku-cli**

**2**. **Vérifier** l'installation (attention au PATH)

        heroku --version

**3**. **Faites login** dans une console

        heroku login -i

**4**. **Créez votre application** Symfony

        symfony new --webapp monapp

**5**. **Créez une application (vide) en Heroku** (vous allez faire push de votre local). Observez votre liste de remotes :

        heroku create -a monapp
        git remote -v 

Un repo sera crée dans Heroku et un remote sera rajouté à votre repo local.

Si vous avez déjà une app et vous voulez que votre repo local pointe vers cette app, lancez:

        heroku git:remote -a monapp

**6**. Créez un fichier ProcFile dans la racine de votre projet contenant ce code :

        web: heroku-php-apache2 public/

Ce fichier indique à Heroku d'utiliser Apache et cherche la page index.php dans le dossier **public** (la structure de Symfony)

**7**. Rajoutez le fichier au repo et faites **commit**
   
        git add ProcFile
        git commit -m "Heroku ProcFile"



**8**. Par défaut, Symfony utilisera l'environnement **dev**. Pour changer ce comportement, lancez :

        heroku config:set APP_ENV=prod

ou 

        heroku config:set APP_ENV=dev


**9**. Rajoutez une BD PosgreSQL à votre projet (section **Resources**)
Clique dans le nom de la BD, puis onglet **Settings** et **Database Credentials**



**9**. Faites **push** à Heroku (pas à votre remote :D) !!

        git push heroku main

Cette action lancera composer install. Si vous avez un problème, pensez à lancer **composer update** et faites les push à nouveau


