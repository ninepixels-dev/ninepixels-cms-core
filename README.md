Ninepixels Seed
========================

Welcome to the Ninepixels Seed server Repository. This is part of Ninepixels Seed Project

1) Installation:
----------------------------------

Clone `ninepixels-seed-server` repo inside ninepixels-seed folder on your local machine

Run installation

    php composer install

Create initial user

    php bin/console fos:user:create

Create application client

    php bin/console app:create-client

Run application

    php bin/console server:run


2) Test application
----------------------------------

Before starting coding, make sure that your local system is properly configured for Symfony.
  
    php app/check.php

3) Development
----------------------------------

For developing purposes there are few commands that you should know

Update database schema 

    php bin/console doctrine:schema:update --force

Generate Getters and Setters

    php bin/console doctrine:generate:entities AppBundle/Entity/{{Entity}}

Clear cache

    php bin/console cache:clear


4) Ninepixels Seed server comes pre-configured with the following bundles:
----------------------------------

  * FrameworkBundle - The core Symfony framework bundle

  * FOSRestBundle - Adds rest functionality

  * FOSUserBundle - Adds support for a database-backed user system in Symfony2

  * FOSOAuthServerBundle - Symfony2 OAuth Server Bundle

  * JMSSerializerBundle - This bundle integrates the serializer library into Symfony2.

  * NelmioApiDocBundle - This bundle allows you to generate a decent documentation for your APIs.

  * NelmioCorsBundle - The NelmioCorsBundle allows you to send Cross-Origin Resource Sharing headers with ACL-style per-URL configuration.

All libraries and bundles included in the Symfony Standard Edition and Mojrokovnik Edition are
released under the MIT or BSD license.