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
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $other_name
 * @property string $username
 * @property string $phone_number
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $referral_code
 * @property string|null $gender
 * @property string $nationality
 * @property string|null $date_of_birth
 * @property string|null $banned_at
 * @property string|null $banned_reason
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $service
 * @property string $code
 * @property string $amount
 * @property string $name
 * @property \App\Enums\DurationType $duration_type
 * @property string $duration
 * @property string|null $size
 * @property string|null $size_unit
 * @property string|null $extras
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\SizeUnit $size_type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VtPassPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VtPassPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VtPassPlan query()
 */
	class VtPassPlan extends \Eloquent {}
}

