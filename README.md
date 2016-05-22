# Lavoter
Voteable Polymorphic Eloquent Models for Laravel 5 without user authentication.

## Installation

First, pull in the package through Composer.

```js
composer require zvermafia/lavoter
```

Include the service provider within `config/app.php`.

```php
'providers' => [
    ...
    Zvermafia\Lavoter\LavoterServiceProvider::class
],
```

You need to publish and run the migration.

```
php artisan vendor:publish --provider="Zvermafia\Lavoter\LavoterServiceProvider"
php artisan migrate
```

You must to include a view part of this package to your site template for frontend section.
For example:

```html
<!-- Let's imagine this is a base template for your frontend section -->
<!DOCTYPE html>
<html lang="en">
	<head>
	    <title>@yield('title', 'The App Name')</title>
	</head>
	<body>
	    @yield('body')

	    <!-- Don't forget jQuery must be included too  -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    
	    <!-- And here a view part of this package -->
	    @include('lavoter::get')
	</body>
</html>
```

At last include the cookie name (uuide) within `app/Http/Middleware/EncryptCookies.php`.
For example:

```php
<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'uuide',
    ];
}
```


-----

### Setup a Model
```php
<?php

namespace App;

use Zvermafia\Lavoter\Contracts\Voteable;
use Zvermafia\Lavoter\Traits\Voteable as VoteableTrait;
use Illuminate\Database\Eloquent\Model;

class Article extends Model implements Voteable
{
    use VoteableTrait;
}

```

### Usage

```php
// Before you need to import a Vote model
use Zvermafia\Lavoter\Models\Vote;

// Sum of all votes
Vote::sum($article);

// Count all votes
Vote::count($article);

// Count all up-votes
Vote::countUps($article);

// Count all down-votes
Vote::countDowns($article);

// Count all votes between two dates
Vote::countByDate($article, '2015-06-30', '2015-06-31');

// Up-vote
Vote::up($article);

// Down-vote
Vote::down($article);
```

In views you can use features which are realized in Voteable trait. For example:

```html
@forelse($articles as $article)
    <article>
        <h1>{{ $article->title }}</h1>
        
        <!-- Voting info -->
        <aside>
            <span class="vote vote-up">{{ $articel->vote_ups }}</span>
            <span class="vote vote-total">{{ $articel->vote_total }}</span>
            <span class="vote vote-down">{{ $articel->vote_downs }}</span>
        </aside>
    </article>
@empty
    <div class="alert alert-info">
        No data.
    </div>
@endforelse
```
