# ADC_V2
Code source de l'application web Arbre de clôture V2

## Prérequis :
 **- Symfony 1.1.5**
 <br> 
 **- Yarn 1.22.1**
 <br>
 **- Node.js 12.14.1**
 <hr>

 
## Procédure d'installation / lancement :
#### < ! > Toutes les commandes ont été executées via un invite de commande de type **git bash** < ! >

#### Se rendre à la racine du dossier "ADC_V2" exécuter les commandes suivante :
 `composer install`
 <br>
 `yarn install`

#### Lancement du serveur (Symfony) :
 `yarn encore dev`<br>
 `symfony server:start`<br>
##### _Vous avez aussi la possibiliter de lancer directement le script :_
`start.sh`

#### Ouverture de l'app via une page web :
 `symfony open:local`

<hr>

## Annexes :
#### Commandes :

 - ###### composer install = installation des dépendances
 - ###### yarn install = installation du moteur de style (scss) pour les templates
 - ###### yarn encore dev = compilation des éléments de style
 - ###### symfony server:start = lancement du serveur symfony
 - ###### symfony server:start -d = lancement du serveur symfony en tâche de fond
 - ###### symfony server:stop = arrêt du serveur symfony
 - ###### symfony server:log = Voir le dernier message des logs
 - ###### symfony open:local = ouvre l'outil via une page web
 - ###### APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear = Vider le cache de symfony (corrige certain problèmes)

#### Liens vers les documentations utiles :
- https://git-scm.com/docs
- https://symfony.com/doc/current/index.html


