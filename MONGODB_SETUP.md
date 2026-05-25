# MongoDB Transition Guide for EcoSync

This guide explains how to transition the EcoSync Smart Waste & Sanitation Management System database driver from **SQLite** to **MongoDB** once your local PHP environment has the MongoDB extension enabled.

---

## Step 1: Install the PHP MongoDB Extension
MongoDB requires the local PHP runtime to load the MongoDB C extension.

1. **Download the DLL**: Find the version matching your PHP version (currently **8.2.12 ZTS x64**) on [PECL MongoDB](https://pecl.php.net/package/mongodb).
2. **Add to ext**: Copy the `php_mongodb.dll` file into your PHP extensions directory (usually `C:\xampp1\php\ext`).
3. **Configure php.ini**: Open `C:\xampp1\php\php.ini` and add the following line:
   ```ini
   extension=mongodb
   ```
4. **Restart Server**: Restart your web server (e.g. Apache in XAMPP) or CLI terminal session.
5. **Verify**: Run `php -m` in your terminal and ensure `mongodb` appears in the list.

---

## Step 2: Install Laravel MongoDB Package
Run the following composer command inside your project directory to install the official MongoDB Eloquent integration for Laravel 11/12:

```bash
composer require mongodb/laravel-mongodb
```

---

## Step 3: Update Environment Configurations
Update your `.env` file to replace the default SQLite settings with the MongoDB connection details:

```env
# Remove or comment out these SQLite configurations:
# DB_CONNECTION=sqlite
# DB_DATABASE=...

# Add these MongoDB configurations:
DB_CONNECTION=mongodb
MONGODB_URI=mongodb://127.0.0.1:27017
MONGODB_DATABASE=ecosync_db
```

---

## Step 4: Adapt Eloquent Models
Because MongoDB uses a different base Eloquent class, update your Eloquent models to extend MongoDB's specific classes:

### 1. Update `app/Models/User.php`
Replace:
```php
use Illuminate\Foundation\Auth\User as Authenticatable;
```
With:
```php
use MongoDB\Laravel\Auth\User as Authenticatable;
```

### 2. Update `app/Models/SanitationReport.php` & `app/Models/RecyclingRequest.php`
Replace:
```php
use Illuminate\Database\Eloquent\Model;
```
With:
```php
use MongoDB\Laravel\Eloquent\Model;
```

---

## Step 5: Run Migrations & Seeding
Once the connections and models are updated, execute the migrations to build your database indexes and seed default administrative/member accounts:

```bash
php artisan migrate --seed
```

Your EcoSync application will now be running fully on **MongoDB**!
