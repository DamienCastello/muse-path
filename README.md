# SoundStore Project v1.0.0

## Philosophie du projet
Ce projet est développé en open source et collaboratif.
Il a pour objectif de regrouper des ressources intéressante pour les compositeurs amateur ou professionnel, gratuite ou payante.
Son but est aussi de proposer aux artistes de se contacter et de publier leurs sons en cours de progression pour avoir des feedback d'autres artistes.
Tous les fonds dégagés par les ventes seront affichés dans un board (si possible en temps réel). La transparence sera un point vital de la plateforme car les bénéfices serviront à subvenir aux besoins d'infrastructure (serveurs, autres ?) de la plateforme et tous les bénéfices seront reversés à des associations de teufeur (à définir).
Pour participer au projet, cloner le projet, choisir une tâche sur le trello, développer la feature/fix et push en respectant la sémantique des branches et commits et effectuer les PR vers la branche dev.
Penser à mettre à jour le trello lorsque nécessaire et respecter le workflow mis en place.

## Fonctionnalités Cøre
- Partager des ressources (pack de sample, articles, formation/tuto) gratuitement  OU payante
- Permettre aux utilisateurs d'accéder à un board affichant les couts et les frais de la plateforme (si possible en temps réel)
- Permettre aux utilisateurs d'effectuer un don
- Regrouper les packs de sample par types (son synthétisé, vocaux enregistrés, autre ?) et par classements qualitatif (critère à définir) afin de permettre aux utilisateurs de trouver plus facilement des ressources intéressantes pour composer
- Permettre aux utilisateurs de partager leurs productions en cours de progression afin d'avoir des feedbacks d'autres artistes dans un canal approprié
- Permettre aux utilisateurs de s'envoyer des messages entre eux et réagir au contenu dans l'application

## Stack
Composer & npm are used to manage dependencies
*requirements :*
- composer >= 2.6.5
- php >= 8.1
- npm >= 8.1.2
- node >= 16.15.1

first add `.env` file in the root folder of project and complete following lines
```text
DB_USERNAME=root
DB_DATABASE=db_soundstore_dev
DB_HOSTNAME=127.0.0.1
DB_PORT=3306
```

next, download & unzip this folder instead of the public folder in storage/app/
https://drive.google.com/file/d/1yS8CQ-H1aGMNJsnrnvW321-SrFE9ZgOk/view?usp=drive_link
(will be improved by a script in next feature)

after you can run
```shell
composer install && npm install && npm run build
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev && php artisan serve
```

## Rejoindre le projet
Lead dev: Damien Castello

mail: D.Castello.13200@gmail.com
