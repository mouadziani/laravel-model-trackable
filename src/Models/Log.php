<?php

namespace LaravelModelTrackable\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class Log
 * @package App\Models
 */
class Log extends Model
{
    protected $table = 'logs';

    public $guarded = [];

    protected $casts = [
        'properties' => 'collection',
    ];

    public const ACTION_TYPES = [
        'create' => 'Création',
        'update' => 'Modification',
        'delete' => 'Supprission',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public function changes(): Collection
    {
        if (! $this->properties instanceof Collection) {
            return new Collection();
        }

        return $this->properties->only(['old', 'new']);
    }

    public function getChangesAttribute(): Collection
    {
        return $this->changes();
    }

    public function scopeInLog(Builder $query, ...$logNames): Builder
    {
        if (is_array($logNames[0])) {
            $logNames = $logNames[0];
        }

        return $query->whereIn('log_name', $logNames);
    }

    public function scopeCausedBy(Builder $query, Model $causer): Builder
    {
        return $query
            ->where('causer_type', $causer->getMorphClass())
            ->where('causer_id', $causer->getKey());
    }

    public function scopeForSubject(Builder $query, Model $subject): Builder
    {
        return $query
            ->where('subject_type', get_class($subject));
    }

    /**
     * @return string
     */
    public function getCauserFullNameAttribute(): string
    {
        return $this->causer->user->nomComplet;
    }

    /**
     * @param Model $subject
     * @param int $subjectId
     * @param string $action
     * @param string $description
     * @param array $properties
     * @return mixed
     */
    public static function log(Model $subject, int $subjectId, string $action, string $description = '', array $properties = [])
    {
        $auth = Auth::user();

        return self::create([
            'log_name' => $action,
            'description' => $description,
            'subject_type' => get_class($subject),
            'subject_id' => $subjectId,
            'causer_type' => get_class($auth),
            'causer_id' => $auth->id,
            'properties' => $properties
        ]);
    }
}
