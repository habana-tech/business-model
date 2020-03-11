#HabanaTech/BusinessModel

A package to group the diferent pieces of a common project.

##Dynamic Metadata Field
Add a field to hold any metadata on an Entity at DB.
- Use the `HabanaTech\BusinessModel\ORM\Traits\MetadataFieldTrait` trait.

##Dynamic translations
Add a field to hold any translation as metadata on an Entity at DB.
- Use the `HabanaTech\BusinessModel\ORM\Traits\MetadataFieldTrait` trait.
- Use the `HabanaTech\BusinessModel\ORM\Traits\TranslationTrait` trait.
- Implement the `HabanaTech\BusinessModel\ORM\Interfaces\TranslationInterface` interface.

Use the `HabanaTech\BusinessModel\Form\MetadataTranslationType` type onyour forms and configure it
example: 
	`- { property: 'title', type: 'HabanaTech\BusinessModel\Form\MetadataTranslationType', type_options: { field: 'title'} }`

Add the Allowed languages as constants on your services.yml, example:
`
	default_locale: en
    locale: '%default_locale%'
    app_locales: ch|en|fr|de|es
`

Optionally, use the form theme for bootstrap 4
HabanaTech\BusinessModel\Resources\views\metadata_translation_bootstrap_4_layout.html.twig