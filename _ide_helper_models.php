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
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\ArticleType $type
 * @property string $name
 * @property string|null $description
 * @property \App\Enums\Currency $currency
 * @property float|null $std_price
 * @property float $price
 * @property array<array-key, mixed>|null $meta
 * @property-read mixed $discount
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movement> $movements
 * @property-read int|null $movements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereStdPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereUpdatedAt($value)
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $started_at
 * @property string|null $ended_at
 * @property int $left_track_id
 * @property int $right_track_id
 * @property int|null $draw
 * @property int|null $won_track_id
 * @property-read \App\Models\Track $leftTrack
 * @property-read \App\Models\Track $rightTrack
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @property-read \App\Models\Track|null $wonTrack
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight current()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereDraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereLeftTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereRightTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fight whereWonTrackId($value)
 */
	class Fight extends \Eloquent {}
}

namespace App\Models{
/**
 * @property \App\Enums\GameType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 */
	class Game extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $key
 * @property string|null $pictureUrl
 * @property int $tokens
 * @property int $points
 * @property string|null $stripe_customer_id
 * @property string|null $arrived_at
 * @property string|null $authenticated_at
 * @property-read mixed $auth_url
 * @property-read mixed $descriptor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movement> $movements
 * @property-read int|null $movements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movement> $registrationMovements
 * @property-read int|null $registration_movements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $succeededPayments
 * @property-read int|null $succeeded_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Track> $tracks
 * @property-read int|null $tracks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @method static \Database\Factories\GuestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereArrivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereAuthenticatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest wherePictureUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereStripeCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereTokens($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereUpdatedAt($value)
 */
	class Guest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $guest_id
 * @property int|null $payment_id
 * @property int|null $article_id
 * @property \App\Enums\MovementType $type
 * @property array<array-key, mixed>|null $meta
 * @property int|null $chf
 * @property int|null $tokens
 * @property int|null $points
 * @property-read \App\Models\Article|null $article
 * @property-read \App\Models\Guest $guest
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereChf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereGuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereTokens($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movement whereUpdatedAt($value)
 */
	class Movement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $guest_id
 * @property string|null $stripe_id
 * @property \App\Enums\PaymentStatus|null $status
 * @property array<array-key, mixed>|null $stripe_data
 * @property \App\Enums\PaymentPurpose|null $purpose
 * @property float $amount
 * @property \App\Enums\PaymentMethod|null $method
 * @property int|null $article_id
 * @property string|null $description
 * @property numeric|null $original_amount
 * @property array<array-key, mixed>|null $meta
 * @property-read \App\Models\Article|null $article
 * @property-read \App\Models\Guest $guest
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movement> $movements
 * @property-read int|null $movements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereGuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereOriginalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStripeData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $logo_path
 * @property-read mixed $logo_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereUpdatedAt($value)
 */
	class Sponsor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $proposed_by
 * @property string $name
 * @property string $artist_name
 * @property string $spotify_uri
 * @property string $img_url
 * @property string $img_thumbnail_url
 * @property array<array-key, mixed> $spotify_data
 * @property int $priority
 * @property int|null $used
 * @property-read \App\Models\Guest|null $proposedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track queue()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereArtistName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereImgThumbnailUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereProposedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereSpotifyData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereSpotifyUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Track whereUsed($value)
 */
	class Track extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $guest_id
 * @property int $track_id
 * @property int $fight_id
 * @property-read \App\Models\Fight $fight
 * @property-read \App\Models\Guest|null $guest
 * @property-read \App\Models\Track $track
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereFightId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereGuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereUpdatedAt($value)
 */
	class Vote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $guest_id
 * @property int $article_id
 * @property-read \App\Models\Article $article
 * @property-read \App\Models\Guest|null $guest
 * @property-read mixed $url
 * @method static \Database\Factories\VoucherFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereGuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereUpdatedAt($value)
 */
	class Voucher extends \Eloquent {}
}

