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
 * @property int $user_id
 * @property int $transaction_id
 * @property string $reference
 * @property int $amount
 * @property string $network
 * @property string $phone_number
 * @property string $service
 * @property string $status
 * @property string $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Transaction $transaction
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\AirtimeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airtime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airtime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airtime query()
 */
	class Airtime extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $transaction_id
 * @property string $reference
 * @property string $amount
 * @property string|null $tv_identifier
 * @property string $plan
 * @property string $provider
 * @property string $service
 * @property string $status
 * @property string $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CableFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cable query()
 */
	class Cable extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $transaction_id
 * @property string $reference
 * @property int $amount
 * @property string $network
 * @property string $phone_number
 * @property string $plan
 * @property string $service
 * @property string $status
 * @property string $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Transaction $transaction
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\DataTopupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataTopup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataTopup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataTopup query()
 */
	class DataTopup extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $transaction_id
 * @property string $reference
 * @property string $amount
 * @property string $meter_number
 * @property string $provider
 * @property string $service
 * @property string $meter_type
 * @property string|null $token
 * @property string $status
 * @property string $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Transaction $transaction
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ElectricityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Electricity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Electricity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Electricity query()
 */
	class Electricity extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $reference
 * @property string|null $description
 * @property string $type
 * @property int $amount
 * @property int $balance
 * @property string $status
 * @property string $commission
 * @property string $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\TransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 */
	class Transaction extends \Eloquent {}
}

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
 * @property-read mixed $bonus_balance
 * @property-read mixed $main_balance
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Wallet|null $wallet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WalletTransaction> $walletTransactions
 * @property-read int|null $wallet_transactions_count
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
 * @property string|null $label
 * @property \App\Enums\DurationType $duration_type
 * @property string $duration
 * @property string|null $size
 * @property \App\Enums\SizeUnit|null $size_unit
 * @property string|null $extras
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VtPassPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VtPassPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VtPassPlan query()
 */
	class VtPassPlan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $main
 * @property string $bonus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet query()
 */
	class Wallet extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $wallet_id
 * @property string $source
 * @property string $destination
 * @property string $type
 * @property string $reason
 * @property int $amount
 * @property \App\Enums\WalletTransactionStatus $status
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Wallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalletTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalletTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalletTransaction query()
 */
	class WalletTransaction extends \Eloquent {}
}

