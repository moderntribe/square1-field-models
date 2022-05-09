# ACF Field Models

Utilizes [Spatie Data Transfer Objects v2](https://github.com/spatie/data-transfer-object/tree/v2) to provide models for ACF fields that support arrays avoiding needing to remember these field structures and providing autocompletion for your IDE.

## Requirements

- PHP 7.4
- Advanced Custom Fields (or ACF Pro)

## Tests

1. Run `composer install`.
2. Run `composer test:setup` to download and configure test dependencies.
3. Edit [tests/.env](tests/.env) and modify for your system.
4. Create the `tribe_acf_field_models_test` database.
5. Run `composer test:integration` to run tests.


### TODO
- Move this to the [tribe-libs](https://github.com/moderntribe/tribe-libs) monorepo once it supports PHP 7.4.
