🌟 Fonctionnalités principales

	•	CRUD complet : Gestion des entités suivantes :
	•	Animaux
	•	Habitats
	•	Races
	•	Utilisateurs
	•	Services
	•	Rapports vétérinaires
	•	Avis
	•	Contacts
	•	Gestion des permissions des utilisateurs :
	•	Chaque utilisateur, selon son rôle, accède à un tableau de bord personnalisé (Dashboard).
	•	Les permissions varient en fonction des droits assignés (ex. : administrateur, visiteur).
	•	Gestion des avis et des contacts :
	•	Gestion des avis sur les services, habitats, animaux et rapports.
	•	Gestion des contacts et des horaires, avec stockage des horaires en MongoDB.
	•	Expérience utilisateur enrichie :
	•	Accès aux services proposés par le zoo (formulaires, horaires).
	•	Consultation des animaux organisés par univers sur la page des habitats.
	•	Possibilité de rédiger des avis.
	•	Présentation du zoo, avec localisation et informations générales.

 🛠️ Technologies utilisées

Développement et déploiement :
	•	Back-End : PHP avec PDO pour la gestion des bases de données.
	•	Base de données relationnelle : MySQL.
	•	Base de données NoSQL : MongoDB (gestion des horaires via MongoDB Compass).
	•	Gestion des dépendances : Composer.
	•	Variables d’environnement : Dotenv.
	•	Stockage des images : Images stockées localement dans le projet.
	•	Envoi de mails : PHPMailer.

Front-End :
	•	HTML5, Bootstrap : Génération automatique de styles CSS et design responsive.
	•	JavaScript : Interactivité côté client.

Déploiement :
	•	XAMPP ou Docker : Serveur local pour le développement.
	•	Heroku : Hébergement de l’application.

 🚀 Installation et exécution du projet

Option 1 : Avec XAMPP

Pré-requis
	•	XAMPP : Serveur local (Apache et MySQL).
	•	PHP 8.2.4 ou une version plus récente.
	•	Composer : Gestionnaire de dépendances PHP.
	•	Git : Pour cloner le projet.

Étapes d’installation
	1.	Cloner le dépôt : git clone https://github.com/kartmann17/Arcadia.git
cd Arcadia

	2.	Configurer les dépendances avec Composer :
         composer install
	3.	Configurer le serveur local avec XAMPP :
	•	Téléchargez et installez XAMPP.
	•	Déplacez le projet cloné dans le répertoire htdocs de XAMPP.
	•	Lancez les services Apache et MySQL via le panneau de contrôle XAMPP.
	4.	Configurer les bases de données :
	•	MySQL : Créez une base de données nommée arcadia_zoo dans phpMyAdmin.
	•	MongoDB : Configurez les horaires dans MongoDB Compass.
	5.	Accéder au projet :
	•	Dans votre navigateur, ouvrez l’URL suivante :
     http://localhost/Arcadia/

    
Option 2 : Avec Docker

Pré-requis
	•	Docker et Docker Compose : Conteneurisation du projet.

Étapes d’installation

1.	Cloner le dépôt :

 git clone https://github.com/kartmann17/Arcadia.git
cd Arcadia

2.	Lancer les conteneurs avec Docker Compose :
       docker-compose up -d

4.	Configurer les bases de données :
	•	MySQL : Accédez au conteneur MySQL et configurez la base de données arcadia_zoo.
	•	MongoDB : Configurez les horaires dans MongoDB Compass.
5.	Accéder au projet :
	•	Ouvrez votre navigateur et accédez à :
        http://localhost:8080

📞 Contact

Pour toute question ou suggestion, n’hésitez pas à me contacter :
	•	Auteur : Kartmann
	•	GitHub : https://github.com/kartmann17




