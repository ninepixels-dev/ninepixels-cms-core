Ninepixels Seed
========================

Welcome to the Ninepixels Seed server Repository. This is part of Ninepixels Seed Project

1) Installation:
----------------------------------

Clone `ninepixels-seed-server` repo inside ninepixels-seed folder on your local machine

Run installation

    php composer install

Initialize default data for application

    php bin/console app:initialize

Run application

    php bin/console server:run


2) Test application
----------------------------------

Before starting coding, make sure that your local system is properly configured for Symfony.
  
    php app/check.php

3) Development
----------------------------------

For developing purposes there are few commands that you should know

Generate Getters and Setters

    php bin/console doctrine:generate:entities AppBundle/Entity/{{Entity}}

Update database schema 

    php bin/console doctrine:schema:update --force

Clear cache

    php bin/console cache:clear

Creating another user

    php bin/console fos:user:create


4) Ninepixels Seed server comes pre-configured with the following bundles:
----------------------------------

  * FrameworkBundle - The core Symfony framework bundle

  * FOSRestBundle - Adds rest functionality

  * FOSUserBundle - Adds support for a database-backed user system in Symfony

  * FOSOAuthServerBundle - Symfony2 OAuth Server Bundle

  * JMSSerializerBundle - This bundle integrates the serializer library into Symfony.

  * NelmioCorsBundle - The NelmioCorsBundle allows you to send Cross-Origin Resource Sharing headers with ACL-style per-URL configuration.

All libraries and bundles included in the Symfony Standard Edition and Nine Pixels CMS Edition are
released under the MIT or BSD license.