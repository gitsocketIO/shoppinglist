# shoppinglist
Liste de courses en Symfony / VueJS

## Installation
1. Faire les installations des dépendances Symfony avec composer `composer install`
2. Faire les installations des dépendances Front avec yarn `yarn install`
3. Modifier le fichier .env
      1. Environnement de dev par défaut
      2. Modifier l'option DATABASE_URL pour correspondre à votre BDD
4. Lancer les migrations symfony console `symfony console doctrine:migrations:migrate`
5. Lancer le build du Front `yarn build`
6. Lancer notre serveur Symfony `symfony server:start`
7. Notre application est disponible à l'adresse par défaut suivante `http://127.0.0.1:8000/`

## Application
1. Possibilité de créer un compte ``/register``
2. Connexion à l'application via email et password ``/login``
3. Les pages de l'applications sont protégées et demande une authantification
4. Affichage des différentes routes API accessibles ``/api``
5. Page par défaut de l'application ``/home``
6. Possibilité d'ajouter un nouvel article via le bouton ``Ajouter un article``
7. Possibilité de modifier un article via le bouton éditer
8. Possibilité de partager un article via le bouton partager, si on partage un article à un utilisateur, le bouton change pour permettre la suppression de ce partage
9. Possibilté de supprimer un article avec le bouton de suppression
10. L'ensemble des articles partagés avec moi sont afficher en dessous, avec le nom de l'utilisateur qui me l'a partagé
11. Possibilité de se déconnecter via le bouton ``Se déconnecter``