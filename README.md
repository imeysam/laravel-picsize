# Laravel Picsize

[![Latest Version on Packagist](https://img.shields.io/packagist/v/imeysam/laravel-picsize.svg?style=flat-square)](https://packagist.org/packages/imeysam/laravel-picsize)
[![License](https://img.shields.io/github/license/imeysam/laravel-picsize.svg?style=flat-square)](LICENSE)

---

## ✂️ Simple & Flexible Laravel Picsize

**Laravel Picsize** is a simple and flexible Laravel package that helps you to resize images on the fly, then store and reuse the resized versions — all with one line of code.

It’s designed for Laravel projects that need **on-demand thumbnails**, **resized images**, or **optimized storage**, without reinventing the wheel every time.

---

## 📋 Features

✅ Simple Facade: `Picsize::resize($path, $width, $height)`  
✅ Disk-based storage (local, public, S3, FTP, etc.)  
✅ Automatic fallback image if source is missing  
✅ Respects Laravel’s Filesystem & URL helpers  
✅ Auto-creates output folders with proper permissions (local disks)  
✅ Compatible with **Laravel 11.x – 13.x**

---

## ⚙️ Requirements

- **PHP** >= 8.1
- **Laravel** >= 11.x  
- [Intervention Image](http://image.intervention.io/) (included)

---

## 🚀 Installation

Install the package via Composer:

```bash
composer require imeysam/laravel-picsize
```

## 🔧 1️⃣ Add & Customize Config

By default, the package uses these settings:
- `disk` → `public`
- `input_path` → `uploads`
- `output_path` → `images`
- `fallback_image` → `images/default.jpg`

To customize these, **publish the config file**.  
You can do this in two ways:

**Option 1 — Using the Provider name (recommended)**  
```bash
php artisan vendor:publish --provider="Imeysam\Picsize\Providers\PicsizeServiceProvider"
```

**Option 1 — Using the tag `config`**  
```bash
php artisan vendor:publish --tag=config
```  


> `config/picsize.php`

```php
return [
    'disk' => 'public',

    'input_path' => 'uploads',

    'output_path' => 'images',

    'fallback_image' => 'images/default.jpg',
];

```

## ✨ Usage

Once installed and configured, using the picsize is super simple.

You can call the `resize` method using the Facade, or inject the service into your classes.

---

### 📌 Basic Using

```php
use Imeysam\Picsize\Facades\Picsize;

class ImageController extends Controller
{
    public function show()
    {
        // Resize to 400x300 and get the full URL
        $url = Picsize::resize('photos/test.jpg', 400, 300);
        ...
    }
}
```                 

### 🧩 Using Dependency Injection

```php
use Imeysam\Picsize\Picsize;

class ImageController extends Controller
{
    public function show(Picsize $picsize)
    {
        // Resize to 400x300 and get the full URL
        $url = $picsize->resize('photos/test.jpg', 400, 300);
        ...
    }
}
```

### ⚡ Using In Blade

```html
<img src="{{ Picsize::resize('photos/test.jpg', 400, 300) }}">
```


## ⚖️ License ##
- This package is created for Laravel >= 9.x and is released under the **MIT License** and, based on [Intervention Image](https://github.com/intervention/image).
