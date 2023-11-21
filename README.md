# SoundStore Project v1.0.0

## Philosophie du projet
Ce projet est développé en open source et collaboratif.
Il a pour objectif de regrouper des ressources intéressante pour les compositeurs amateur ou professionnel, gratuite ou payante.
Son but est aussi de proposer aux artistes de se contacter et de publier leurs sons en cours de progression pour avoir des feedback d'autres artistes.
Tous les fonds dégagés par les ventes seront affichés dans un board (si possible en temps réel). La transparence sera un point vital de la plateforme car les bénéfices serviront à subvenir aux besoins d'infrastructure (serveurs, autres ?) de la plateforme et tous les bénéfices seront reversés à des associations de teufeur (à définir).
Pour participer au projet, cloner le projet, choisir une tâche sur le trello, développer la feature/fix et push en respectant la sémantique des branches et commits et effectuer les PR vers la branche dev.
Penser à mettre à jour le trello lorsque nécessaire et respecter le workflow mis en place.

## Fonctionnalités Cøre
- Permettre aux utilisateurs d'accéder à un board affichant les couts et les frais de la plateforme (si possible en temps réel)
- Permettre aux utilisateurs d'effectuer un don
- Partager des ressources (pack de sample, articles, formation/tuto) gratuitement  OU payante
- Regrouper les packs de sample par types (son synthétisé, vocaux enregistrés, autre ?) et par classements qualitatif (critère à définir) afin de permettre aux utilisateurs de trouver plus facilement des ressources intéressantes pour composer
- Permettre aux utilisateurs de partager leurs productions en cours de progression afin d'avoir des feedbacks d'autres artistes dans un canal approprié
- Permettre aux utilisateurs de s'envoyer des messages entre eux et réagir au contenu dans l'application

## Stack
Composer is used to manage dependencies
*requirements :*
- composer >= 2.6.5
- php >= 8.1

first add `.env` file in the root folder of project and complete following lines
```text
DB_USERNAME=root
DB_DATABASE=db_soundstore_dev
DB_HOSTNAME=127.0.0.1
DB_PORT=3306
```
after you can run
```shell
composer install
php artisan migrate
launch seeds
php artisan serve
```

## Rejoindre le projet
Lead dev: Damien Castello

mail: D.Castello.13200@gmail.com