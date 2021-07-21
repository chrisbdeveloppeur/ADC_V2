# ADC_V2
Code source de l'application web Arbre de clôture V2

## MAJ 2.01 :
**- Ajout & mise à jour de commentaires**<br>
**- Modification de certaines phrases**<br>
**- Taille du message proposant l'annulation d'une DEM / INC**<br>
**- Suppression du champs de saisi `Asset / Hostname` dans le formulaire `Softs / Applications` de la branche fourniture de matériel**<br>
**- Le retour en arrière est rendu impossible lorsque la chaine de balises finale est générée**<br>
**- Nombre maximal de balises fixé à `15`**<br>
**- Suppression des items `petits matériels` et `imprimantes` dans la branche `autres actions matériel`**<br>
**- Ajout de l'item `Traitement d'un incident de sécurité` générant une balise `SFW_SEC` dans le formulaire `autres actions logiciel et accès`**<br>
**- Le boutton `Annulée` est à présent dès la question N°2**<br>
**- Correction des balises pour les RDV :**<br>
  - `[RDV RESPECTE OUI]` : Le RDV a été respecté, ou bien n'a pas eu lieu pour une raison non imputable à SCC (panne réseau…)
  - `[RDV RESPECTE NON]` : L'utilisateur n'était pas présent au RDV (sans avoir prévenu)
  - `[RDV ANNULE USER]` : Le Rendez-vous a été annulé par l'utilisateur
  - `[RDV NON RESPECTE SCC]` : SCC n'était pas présent au RDV (sans avoir prévenu)
  - `[RDV ANNULE SDP]` : Le Rendez-vous a été annulé par SCC 
  
## Prérequis :
###### Configuration minimal requise
 **- PHP 7.4**
 <br>
 **- Git 2.31.1**
 <br>
 **- Symfony 1.1.5**
 <br>
 **- Node.js 12.14.1**
 <br>
 **- Yarn 1.22.1**

#### Liens des telechargements utiles :
- **Git** : https://git-scm.com/downloads
- **Symfony** : https://symfony.com/download
- **Node.js** : https://nodejs.org/en/
- **Yarn** : https://classic.yarnpkg.com/en/docs/install#windows-stable _(Dans "Alternatives")_

 <hr>

_Toutes les commandes ont été executées via un invite de commande de type **git bash**._<br>
_Des connaissance en **PHP - Symfony** ainsi que **Twig** sont necessaire pour toute compréhension & modification de l'outil._<br>
_La Framework **Bulma** à été utiliser pour le rendu des templates._
## Procédure d'installation / lancement :

#### Récupération du repository :
###### Placez-vous à l'emplacement cible pour la récupération du dossier ADC_V2 et executer la commande suivante
`git clone https://github.com/chrisbdeveloppeur/ADC_V2.git`

#### Installation :
###### Se rendre à la racine du dossier "ADC_V2" et exécuter les commandes suivantes
 `composer install`
 <br>
 `yarn install`

#### Lancement du serveur (Symfony) :
###### Toujours à la racine du dossier "ADC_V2" et exécuter les commandes suivantes
 `yarn encore dev`<br>
 `symfony server:start`<br>
###### _Vous avez aussi la possibiliter de lancer directement le script présent dans le dossier ADC_V2 :_
`./start.sh`

###### Ouverture de l'app via une page web (après que le serveur symfony soit lancé)' :
 `symfony open:local`

<hr>

## Annexes :
#### Commandes :

 - ###### `composer install` = installation des dépendances
 - ###### `yarn install` = installation du gestionaire de package
 - ###### `yarn encore dev` = chargement des packages .scss/.css et .js
 - ###### `symfony server:start` = lancement du serveur symfony
 - ###### `symfony server:start -d` = lancement du serveur symfony en tâche de fond
 - ###### `symfony server:stop` = arrêt du serveur symfony
 - ###### `symfony server:log` = Voir le dernier message des logs
 - ###### `symfony open:local` = ouvre l'outil via une page web
 - ###### `APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear` = Vide le cache de symfony (corrige certains problèmes)

#### Liens vers les documentations utiles :
- **Git** : https://git-scm.com/docs
- **Symfony** : https://symfony.com/doc/current/index.html
- **Composer** : https://getcomposer.org/doc/
- **Twig** : https://twig.symfony.com/doc/3.x/
- **Bulma** : https://bulma.io/documentation/


