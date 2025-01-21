<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Path whereUpdatedAt($value)
 */
	class Path extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $word
 * @property string $translation
 * @property string $context
 * @property string $example
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereExample($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereTranslation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereWord($value)
 */
	class Word extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $path_id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $visibility
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack wherePathId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordPack whereVisibility($value)
 */
	class WordPack extends \Eloquent {}
}

