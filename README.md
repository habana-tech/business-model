# HabanaTech/BusinessModel

A package to group the diferent pieces of a common project.

##Install
    
    composer require habanatech/business-model

## Dynamic Metadata Field
Add a field to hold any metadata on an Entity at DB.
- Use the `HabanaTech\BusinessModel\ORM\Traits\MetadataFieldTrait` trait.

## Dynamic translations
Add a field to hold any translation as metadata on an Entity at DB.
- Use the `HabanaTech\BusinessModel\ORM\Traits\MetadataFieldTrait` trait.
- Use the `HabanaTech\BusinessModel\ORM\Traits\TranslationTrait` trait.
- Implement the `HabanaTech\BusinessModel\ORM\Interfaces\TranslationInterface` interface.

Use the `HabanaTech\BusinessModel\Form\MetadataTranslationType` type onyour forms and configure it
example: 
	`- { property: 'title', type: 'HabanaTech\BusinessModel\Form\MetadataTranslationType', type_options: { field: 'title'} }`

Add the Allowed languages as constants on your `services.yml`, example:

    default_locale: en
    locale: '%default_locale%'
    app_locales: ch|en|fr|de|es


Optionally, use the form theme for bootstrap 4
    `'@HabanaTech_BusinessModel\metadata_translation_bootstrap_4_layout.html.twig'`
add to your `twig.yaml` file

    paths:
        '%kernel.project_dir%/vendor/habanatech/business-model/BusinessModel/templates': HabanaTech_BusinessModel


To read, `$entity->translate('fr')` returns an array with the translated properties.

You'll need add the services:

    HabanaTech\BusinessModel\Form\MetadataTranslationType:  ~ `
    HabanaTech\BusinessModel\EventSubscriber\TranslationsSubscriber: ~`

Or you can add all the services:

    HabanaTech\BusinessModel\:
        resource: '../vendor/habanatech/business-model/BusinessModel/*'
        exclude: '../vendor/habanatech/business-model/BusinessModel/{DependencyInjection,Entity,templates}'

## Entities
**Image, FilterTag, DescriptionFragment**

These entities can be useful, remember add a listener to doctrine ORM for your relations
https://symfony.com/doc/current/doctrine/resolve_target_entity.html   

example: in file doctrine.yaml 

    orm:
        resolve_target_entities:
            HabanaTech\BusinessModel\ORM\Entity\Image: App\Entity\Service
