

# MultiLangEntities Package

The `mnaimjons/multi-lang-entities` package allows you to easily manage multi-language (localized) entities in Laravel projects. This package provides a flexible way to translate attributes of any Eloquent model in Laravel.

## Installation

1. Require the package via Composer:

    ```bash
    composer require mnaimjons/multi-lang-entities
    ```

2. (Optional) Publish the configuration file:

    You can publish the configuration file to customize the default locale and other settings.

    ```bash
    php artisan vendor:publish --provider="Mnaimjons\MultiLangEntities\MultiLangEntitiesServiceProvider" --tag="config"
    ```

    This will publish the configuration file `config/multi_lang_entities.php` to your Laravel application.

## Configuration

Once the configuration file is published, you can customize the following options:

```php
return [
    'default_locale' => env('APP_LOCALE', 'en'), // Default locale
    'eager_loading' => false,                    // Whether to use eager loading for translations
];
```

## Usage

To use the package in your Laravel models, you can add the `HasTranslations` trait to any Eloquent model and define which attributes should be translatable.

### Step 1: Add Translatable Attributes

Add the `HasTranslations` trait to your model and define the attributes you want to translate by adding the `$translatable` property.

**Example with Category Model:**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mnaimjons\MultiLangEntities\Traits\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $fillable = ['slug'];

    // Define the translatable attributes
    protected $translatable = ['name', 'description'];
}
```

### Step 2: Adding Translations

You can add or update translations for any of the defined translatable attributes by calling the `setTranslations` method on the model.

**Example:**

```php
$category = Category::find(1);

$category->setTranslations([
    'name' => 'Category Name in English',
    'description' => 'Description in English'
], 'en');  // Adding translation for 'en' (English)

$category->setTranslations([
    'name' => 'Category Name in French',
    'description' => 'Description in French'
], 'fr');  // Adding translation for 'fr' (French)
```

### Step 3: Retrieving Translations

You can retrieve translated attributes using the standard Eloquent model attribute accessors. The package automatically uses the current application locale (`app()->getLocale()`) to return the appropriate translation.

**Example:**

```php
$category = Category::find(1);

// Get the translated name and description based on the current locale
echo $category->name;       // Output: Translated 'name' attribute
echo $category->description; // Output: Translated 'description' attribute
```

### Step 4: Changing Locale

If you want to retrieve translations in a specific locale other than the current application locale, you can pass the desired locale to the `getTranslatedAttribute` method.

**Example:**

```php
$category = Category::find(1);

// Retrieve translations for the 'fr' locale (French)
$nameInFrench = $category->getTranslatedAttribute('name', 'fr');
$descriptionInFrench = $category->getTranslatedAttribute('description', 'fr');
```

### Step 5: Eager or Lazy Loading Translations

By default, translations are **lazy-loaded** (loaded on demand). If you want to **eager-load** translations to improve performance, use the `withTranslations` method.

**Example:**

```php
$category = Category::find(1)->withTranslations();  // Eager-load translations

echo $category->name;  // Will use eager-loaded translations
```

## Artisan Commands

The package provides several Artisan commands to manage translations from the command line:

1. **List Translations**: Display all translations for a specific entity.

    ```bash
    php artisan translations:list "App\Models\Category" 1
    ```

   This will list all translations for the `Category` model with ID `1`.

2. **Add or Update Translations**: Add or update a translation for a specific attribute.

    ```bash
    php artisan translations:add "App\Models\Category" 1 en name "New Category Name"
    ```

3. **Remove Translation**: Remove a specific translation.

    ```bash
    php artisan translations:remove "App\Models\Category" 1 en name
    ```
