# multi-lang-entities
A Laravel package for handling multi-language entities

#### **Installing a package:**

To install, run:

```bash
php artisan multi-lang-entities:install
```

To publish the configuration, run:
```bash
php artisan vendor:publish --provider="Mnaimjons\MultiLangEntities\MultiLangEntitiesServiceProvider" --tag="config"
```

#### **Working with Artisan commands to manage translations:**

- **List translations:**

```bash
php artisan translations:list "App\Models\Category" 1
```

- **Add a translation:**

```bash
php artisan translations:add "App\Models\Category" 1 en name "New Category Name"
```

- **Remove a translation:**

```bash
php artisan translations:remove "App\Models\Category" 1 en name
```
