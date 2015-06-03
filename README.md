![HelpDesk](http://angular.kobject.net/git/phalconist/helpdesk.png "HelpDesk")

# Rappel du projet

Vous travaillez au sein d'une PME en tant que Responsable du support aux utilisateurs. Dans le cadre de votre travail, vous gérez aussi bien les incidents que les demandes d'assistance technique ou fonctionnelle sollicitées par les utilisateurs.
Les demandes d'assistance ou remontées d'incidents ne sont pour l'instant pas informatisées, et les utilisateurs doivent vous contacter directement, par mail ou par téléphone, pour vous communiquer ces informations.
Ce procédé est coûteux en temps, insatisfaisant pour les utilisateurs dont les demandes sont parfois oubliées. Il ne permet pas d'obtenir une traçabilité des actions d'exploitation menées.
Vous avez un temps envisagé la mise en place de solutions existantes (GLPI + OCS), mais ces solutions sont trop complètes, parfois trop complexes pour le SI de votre entreprise.
Vous avez donc décidé de réaliser une application Web permettant de gérer les demandes d'assistance, et dont les fonctionnalités sont adaptées à vos besoins.

# Composition de notre groupe

* Samy SLAMA
* Aurélien JANVIER

# Tâches à effectuer

Sur cette plateforme, nous avons du réaliser :

## Le système de tickets

Lorsqu'un utilisateur souhaite contacter l'administrateur (pour un problème ou une question), il peut envoyer un ticket et y poster des messages.
L'administrateur peut voir la liste des tous les tickets, y poster des messages pour répondre, les supprimer et les éditer pour modifier leur statut.

## La base de connaissances

La base de connaissance ressence des articles rédigés par l'administrateur et répondant aux questions et problèmes les plus courants.
Ils sont consultables par les utilisateurs.
A chaque consultation, la popularité d'un article est incrémentée.

# Répartition des tâches

Au vu du peu de temps nous ayant été donné pour réaliser ces tâches, nous avons décidé de ne pas les diviser mais de les réaliser ensemble.
En effet, notre niveau de compétences en web dynamique est totalement différent et il aurait été peu judicieux de travailler chacun de notre côté.

Nous avons d'abord décidé de découvrir le framework de M. Héron ensemble afin de comprendre le principe "Modèle Vue Contrôleurs" et son fonctionnement.

Ensuite, nous avons réalisé la majeure partie du code en réfléchissant ensemble aux moyens de réaliser les tâches demandées.

# Installation

Pour installer l'application Helpdesk, il vous faut :

* Un serveur Apache avec PHP
* Un serveur MySQL
* Un client Git (de préférence)

Récupérez les fichiers du projet en faisant un 
    git clone https://github.com/ajanvier/helpdesk.git
    
Ou en [téléchargeant l'archive ZIP](https://github.com/ajanvier/helpdesk/archive/master.zip)

Importez sur MySQL le fichier app/database/helpdesk.sql

Connectez vous sur votre serveur web dans le dossier helpdesk
