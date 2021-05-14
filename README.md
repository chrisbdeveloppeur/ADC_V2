# ADC_V2
Code source de l'application web Arbre de clôture V2

Prérequis :
 - Symfony 1.1.5
 - Yarn 1.22.1
 - Node.js 12.14.1
  
Toutes les commandes ont été executées via un invite de commande comme git bash.
 
Procédure d'installation :

Se rendre à la racine du dossier "ADC_V2" exécuter les commandes suivante :
 - composer install
 - yarn install

Lancement du serveur (Symfony) :
 - yarn encore dev
 - symfony server:start

Ouverture de l'app via une page web :
 - symfony open:local

Commandes :

 - composer install = installation des dépendences
 - yarn install = installation du moteur de style (front-end)
 - yarn encore dev = compilation des éléments de style
 - symfony server:start = lancement du serveur symfony
 - symfony server:start -d = lancement du serveur symfony en tâche de fond
 - symfony server:stop = arrêt du serveur symfony
 - symfony server:log = Voir le dernier message des logs
 - symfony open:local = ouvre l'outil via une page web




