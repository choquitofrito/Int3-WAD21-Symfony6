**Installation de XDebug : debugging en PHP**
=============================================

<br>

**1.**  Vérifiez **si vous avez déjà** le fichier du module XDebug dans votre disque : allez dans **xampp/php/ext** et cherchez le fichier **php\_xdebug.dll**

 Si c'est le cas, vous avez déjà le module et il reste qu'à l'activer.
 Passez alors directement au point 3 de ce tutoriel

<br>

**2.** **Téléchargez XDebug** de xDebug.org (https://xdebug.org/download#releases)
   

Vous devez cherchez le fichier de XDebug qui correspond à votre version de PHP. Ce n'est pas un 'logiciel', c'est juste une librairie DLL. Pour savoir quoi télécharger, vous devez connaitre votre version de PHP ainsi que d'autres infos importantes.

Créez un fichier **info.php** dans c:/xampp/htdocs contenant ce code:
 
 
 ```php
 <?php
  php_info()
 
 ```
 
Ouvrez cette page (**localhost/info.php** dans la barre d'adresses du navigateur) et vous verrez plein d'info sur votre installation de PHP.

Le **fichier de XDebug** à télécharger sera celui dont la **version de PHP correspond à la version de PHP qui nous montre php_info** (en haut de la page). 

On doit choisir entre (TS ou non-TS). Cherchez dans la page de php_info la ligne "thread safety": si la valeur est 'enabled', choisissez la version **TS** de XDebug. Si disabled, la version où on ne spécifie pas TS (non-TS).

La version sera toujours **64-bits** sauf si vous avez installé XAMPP dans une cafetière italienne ou un tamagotchi.





 En Windows il s'agit d'un fichier dll. Le plus simple est de renommer le fichier à **php\_xdebug.dll**. Puis, placez-le dans **xampp/php/ext** pour qu'il soit accèssible par Apache

<br>

**3.** **Editez le fichier php.ini (xampp/php)**

 Créez la section **\[XDebug\]** contenant les lignes suivantes (à la fin du fichier php.ini, par exemple). Le fichier **php\_xdebug.dll** est le fichier que vous avez téléchargé :

```apache
zend_extension = "C:\xampp\php\ext\php_xdebug.dll"
;xdebug.mode = debug
;xdebug.start_with_request = yes
;xdebug.client_port = 9090
;xdebug.remote_host = "127.0.0.1"
```
 **Note** : cette section peut exister déjà. Si c'est le cas, mettez-la à
 jour. Rajustez les chemins selon vos besoins

<br>

**4.**  **Vérifiez que XDebug est installé**:

4.1.  Si vous n'avez pas du le créer avant, créez le fichier le fichier **info.php** dans c:/xampp/htdocs contenant ce code:
  
 ```php
<?php
php_info()

 ```

4.2.  Redemarrez Apache

4.3.  Relancez la page info.php et cherchez la section **xdebug (CTRL-F)**. Le module doit être marqué comme **enabled**.

4.4. Rajoutez un simple ligne de **var_dump** avant php_info et observez que le format d'affichage a changé

```php
<?php
var_dump (['Pepi','Luci','Sandrine'])
php_info()
```
