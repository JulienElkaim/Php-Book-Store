Projet Base de données 2018
===========================
<br>
*__School Project: January 2018__*

Book Store application using Php as a back-end language and MySQL as the database SGBD.


____
Paramètres de rendu de projet
-----------------------------

**Professeur :** Sabrine MALLEK
**Étudiant :** Julien ELKAIM
**Date limite :** 14/01/2018
**Date de rendu :** 13/01/2018



Pré - requis à l'utilisation
----------------------------


### 1. Informations de Log In

Les paramètres de connexion sont éditables dans le fichier **cmp/logDATAS.php** .
Il ne faut néanmoins pas toucher à la variable $base = "MyBooks". En effet, le nom est parfois référé en *dur* dans le code, la modification de ce paramètre entrainerait l'échec de beaucoup de fonctions.

L'application ne peut se lancer que depuis index.php . Un 'court-circuit' réalisé en se connectant directement à des feuilles php manuellement entrainerait un dysfonctionnement de l'application.

### 2. Si la base de données n'existe pas mais est vue existante

Le programme utilise une variable enregistrée dans un fichier json pour vérifier l'existante ou non de la base de données sur votre machine.

Concrètement, cette variable est modifiée au moment de Log In / Log Off à partir de l'application index.php .

Si il se trouve que l'application pense que la base de données existe mais qu'elle ne l'est pas *(Ex: Vous avez supprimé la base depuis phpMyAdmin)* **la solution est de modifier la valeur de cette variable à la main: de true à false !**

### 3. Bootstrap & JQuery
Pour utiliser cette base de données il vous est demandé d'avoir une connexion internet pour:

* Utiliser Bootstrap.
* Utiliser AJAX des JQuery JavaScript.


_**Si vous ne pouvez pas vous connecter à internet,** une version de JQuery est disponible à l'adresse 'js/jquery.js', la référence à JQuery està modifier dans les feuilles suivant:_

* index.php
* insertion.php
* requetes.php
* insertMANUAL.php
* Index\_Have\_To\_Log\_On.php

il est néanmoins recomandé d'utiliser la version google de JQuery.


Fonctions de l'application
--------------------------
### 1. Connexion, Création, Display

L'application permet de se connecter et de créer simplement la base de données. Il est possible de modifier les données présentes nativement dans la base en modifiant les fichiers:

* *src/Auteur.csv*
* *src/Editeur.csv*
* *src/Livre.csv*
* *src/Edite_par.csv*
* *src/Ecrit_par.csv*

Les informations de connexion sont dans le fichier cmp/logDATAS.php.
Il est également possible d'afficher les tables par simple menu déroulant disponible dans index.php et insertion.php

### 2. Insert | Suppr de données

L'utilisateur peut choisir de **supprimer**, **modifier**, ou **insérer** un élément. L'insertion se fait de deux manières.

**Insertion par fichier CSV**, il est demandé de renseigner si votre fichier csv comporte une ligne d'en-tête. Si oui, laissez cochée la case correspondante. Il vous suffit de renseigner le chemin relatif / absolu de votre fichier csv pour procéder au téléchargement des données dans la table affichée. Si une erreur survient lors de l'insertion, les lignes précédent l'erreur sont tout de même insérées.

**Insertion manuelle**, se confond avec la modification. Pour insérer une nouvelle ligne dans la table, il est **requis** de remplir tous les champs d'insertion ! Si toutefois vous désirez ne pas indiquer une des valeurs, veuillez insérer un simple tiret.
Le serveur comprendra que vous voulez insérer une valeur nulle.

**Sachez que dans le mode modification**, si vous modifiez une partie ou toute la clef primaire de la table, vous repassez en mode insertion pour insérer une nouvelle donnée.

### 3. Requêtes SQL sur la base

La page des requêtes propose un menu déroulant avec les 19 requêtes requises par l'énnoncé. L'intitulé des requêtes de 1 à 15 sont les exactes intitulés proposés dans l'énnoncé. Les requêtes 16 à 19 sont des requêtes supplémentaires de ma proposition. Si l'intitulé n'est pas assez explicite vous pouvez me contacter par mail :

**julienelk@gmail.com**

le résultat des requêtes est donné sous forme de tableau simple à la suite du menu déroulant.

Choix d'implémentation et de développement
---------------------------

### 1. Gestion des éléments et des fonctions

Le projet s'organise en dossiers, avec en tête de dossier principal les fichiers php qui vont diriger les opérations de l'application. J'ai préféré diviser le plus possible mes éléments en sous fichiers php. J'y vois 3 avantages pour moi :

* Pouvoir ré-utiliser un élément plus facilement si besoin est.

* Réduire la taille de mon code pour améliorer sa lisibilité.

* Le rendre plus facile à modifier et restructurer.

Les fonctions sont elles regroupées en fonction de l'interface qu'elles servent: index, insertion, requêtes. Ce choix me permet de diviser le projet en 3 sous catégories, ce qui me permet de mieux comprendre mon code.

### 2. Passage par JQuery pour la communication inter-page

Pour gérer la communication inter-pages j'aurais pu utiliser de multiples sous form qui communiquent en POST. J'y voyais là deux problèmes majeurs:

* Le manque de liberté dans les actions à réaliser.

* L'utilisation de form là où la pratique n'en demande pas. (Un bouton seul n'est pas un forme normalement...)

J'ai donc implémenté à certains endroits une communication AJAX. Je préfères également proposer une connexion AJAX à partir de google plutôt que le fichier en local. Ce choix oblige néanmoins l'utilisateur à être connecté à internet.

### 3. Choix d'une ultra variable en json

Pour vérifier l'existance de la base, je préfères passer par une variable stockée plutôt que de vérifier directement. Je préfères cette méthode puisqu'elle m'évite de me connecter au serveur dès l'ouverture de index.php (mieux pour débugguer sans rajouter de problème). Cela évite également la page blanche dès l'ouverture de l'application, juste parce qu'il y aurait des erreurs d'informations dans les logs.

### 4. Du 2 en 1: Modification / Insertion

J'ai ajouté la modification à l'insertion. Je l'ai fait de cette manière pour 2 raisons:

* Avec la présence de clefs étrangères dans les tables de relation, cela devient impossible de modifier une ligne en modifiant au même moment sa clef primaire, puisque la clef étrangère l'empêcherait. Fusionner l'insertion et la modification permet donc de switcher plus vite entre les deux fonctionalités.

* Un gain de place sur la page d'insertion déjà chargée.

### 5. Les requêtes réalisées

Les requêtes ont été réalisées en dur. Cela signifie que le nom de la base et des tables, colonnes, sont écrites à la main directement dans le code source. Ce choix est fait pour faciliter la lecture de la query et ne pas venir la complexifier avec des insertions de variable php dans la chaine d'instruction.


Travail et difficultés
----------------------

###Temps de travail
**J'ai réalisé le projet sur 7 jours, sur un temps d'environ 30 heures.**
Le temps d'analyse et de structuration a été important car je ne connaissait pas le principe des pages dynamique, encore moins le php, et encore moins le javascript que j'ai décidé d'insérer à mon projet.

A été également chronophage, la résolution de bug tel que les problèmes d'encodage (en changeant de machine, ou même de contexte server->client), ou encore en implémentant les requêtes AJAX qui sont compliquées quand on a pas les bases de JS.

###Difficultés
Par ordre décroissant, mes principales difficultés ont été:

* Problèmes JavaScript et AJAX
* Compréhension & structuration du projet
* Insertion de boutons
* Connexion / Création dynamique à la base de données
* Problème d'encodage des données

Certains de mes choix ont été guidés par les réponses mail que j'ai reçu sur des sujets ambigüs à mon sens:

* **Question 11 - Livre :** Il faut sortir un tableau listant tous les éditeurs, avec en face leur liste respective d'auteurs publiés sous leur nom.

* **Encodage des données:** Ceci n'est pas la priorité de ce projet, ainsi même si j'ai corrigé l'affichage actuel, je ne me suis pas penché sur des difficultés d'encodage pouvant intervenir sur d'autre type de machine.

* **La forme des résultats de requête:** La phrase précisant que les données sont à rendre *brut* indique en fait qu'il ne faut pas tricher et réaliser les requêtes par des astuces de php. L'affichage peut donc se faire sous forme de tableau, et non en affichant avec print_r ou var_dump la donnée brut du résultat sql.


