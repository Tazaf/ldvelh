# ldvelh

## Français

### Résumé

Ce projet a pour but d'aider les joueurs de LDVELH (Livre Dont Vous Êtes Le Héros) à gérer leur personnage. Actuellement, seul un LDVELH est supporté : le Labyrinthe de la Mort par Ian Livingstone.
Il a été mise sur pied comme projet d'école pour un cours de PHP. À cause du temps limité à disposition et des connaissances à lacunaires de l'époque, il est relativement limité à l'heure actuelle et ne permet pas d'ajouter facilement la gestion de nouveaux livres, encore moins de nouvelles règles de jeu. De plus, le but de ce projet d'école était de nous faire développer une application depuis la base sans aucune aide de framework ou de plug-ins.

### Détails technique

Cette v-1.0 a été développé à partir de rien et est basé sur le modèle MVC (Modèle - Vue - Contrôleur).
Les règles utilisées sont celles de la série "Les Défis Fantastiques".
Les monstres et équipements disponibles sont ceux du livre "Le Labyrinthe de la Mort".
Le texte des paragraphes n'est pas disponible. Il est donc nécessaire de posséder le livre pour utiliser la v-1.0.
Certaines spécificités des règles n'ont pas pu être prises en compte, soit par manque de temps, soit par manque de connaissances quant au moyen de les implémenter. Ces règles sont : 
* La gestion de la fuite : dans le livre, il n'est pas possible de fuir tout les monstres et lorsque c'est possible, cela obéit à des règles bien précises. Ces règles de fuites ne sont pas implémentées. Il est actuellement possible de fuire tout les combats.
* Les types des combats : selon les situations, lorsque le joueur rencontre plusieurs monstres en même temps, soit il les combat un à un, soit il les combats en même temps. Cette gestion des combats à plus d'un contre un n'est pas supportée.
* Les conditions de victoire : outre la mort du héros ou celle du ou des monstres qu'il combat, certains combats peuvent être terminés par d'autre moyens. L'utilisation d'un objet s'il est présent dans l'inventaire du héros, un résultat de dés particulier, un certain nombre d'assauts réussis ou échoués, etc. Pour l'instant, la seule manière de terminer un combat est de tuer le monstre ou d'être tué.
* L'effet de certains objets : des objets tels que les armes ou le bouclier ont des effets sur les statistiques du joueur. Les règles présentes dans le livre n'étant pas très claire sur la manière dont ces effets agissent, ils n'ont pas été pris en compte.

Aucune gestion de l'authentification n'existe actuellement, ce qui laisse la possibilité à tous les visiteurs de créer, supprimer ou jouer avec n'importe quel personnage déjà existant.

### Installation de la v-1.0

Pour installer la v1.0, il vous faut suivre les étapes suivantes :
* Premièrement, faites une copie de ce projet à l'endroit où vous souhaitez l'installer
* Allez dans /application/View/, dézippez Smarty.zip dans le dossier où il se trouve
* Dans votre SGBD, créez une nouvelle base de données.
* Nommez là comme bon vous semble, mais paramétrez-la en utf8-general-ci
* Dans cette base de données nouvellement créée, importez dump_structure.sql
* Importez ensuite dump_data.sql
* Allez /application/ et ouvrez le fichier bdconnect.php
* Modifiez les paramètres nécessaires pour que leur valeur correspondent à celles utilisez dans votre base de données précédemment créée.
* C'est fini !

## English

### Summary

This project is an attempt to help players of adventure gamebooks books in managing their character. Right now, only one book is supported : Deathtrap Dungeon by Ian Livingstone.
It was created as a school project for a PHP course. Because of the limited time available and the then incomplete knowledge of PHP and the MVC pattern, it's quite limited as for now and can not be easily expand in supporting other books, let alone other game rules. Therefore, the purpose of the course was to develop an application from scratch without any framework or plug-ins.

### Technical details

This v-1.0 was developped from scratch and based on the MVC (Model - View - Controller) design pattern.
The used rules are the ones from the Fighting Fantasy series.
Monsters et equipments available are from the book Deathtrop Dungeon.
The actual text of the text section is not available. Therefor, it's required that you possess the book in order to use the v-1.0.
Some rules are not supported, either due a to lack of time or a lack of knowledge about how to implements them. This rules are :
* Escape conditions : in the book, it's not possible to escape every encounter and the one from which the player is able to escape are bound to specific conditions. This conditions are not implemented. As for the v-1.0, it's possible to escape every started fight
* Fight types : depending on the situation, when the player encounter several monsters in the same location, he's instructed by the book to fight them either one after another or all in the same time. Right now, every fight is a one-vs-one type.
* Victory conditions : in the book, it's possible to end a fight without actually killing the monster or being killed. Using one special item if it is in your backpack, a special dice result, a special number of failed or successfull assault, etc. Right now, you can't finish a fight without killing the monster or being killed.
* Items effets : items like weapons or shield can have an effect on the player attributes. The rules in the book being vague about how these effets work, they are not implemented as for now.

There is no authentication whatsoever. This means that every user can create, delete or use any existing character.

### How to install v-1.0

In order to install this v1.0, please follow this steps :
* First, clone this project where you want to install it
* Go to /application/View/ and unzip Smarty.zip in this same directory
* In your favourite DBMS, create a new database
* Name it as you wish, but don't forget to set it in utf8-general-ci
* In this newly created database, import dump_structure.sql
* Then import dump_data.sql
* Go to /application/ and open the bdconnect.php file
* Modify the needed parameters in order for them to match the value used in the previously created database
* That's it !
