<?php

namespace LaravelModelTrackable\Traits;

use LaravelModelTrackable\Models\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait Trackable
{

    /**
     * Array of changed attributes
     *
     * @var array
     */
    private static $changedAttributes = [];

    protected static function bootTrackable()
    {
        static::updated(function ($model) {
            $changedFields = array_keys(Arr::except($model->getChanges(), static::UPDATED_AT));
            self::$changedAttributes['old'] = Arr::only($model->getRawOriginal(), $changedFields);
            self::$changedAttributes['new'] = $model->changes;
        });
    }

    /**
     * Get array of changed attributes
     *
     * @return array
     */
    public function getChangedAttributes()
    {
        if(
            property_exists(self::class, 'toBeLoggedRelations')
            &&
            is_array($this->toBeLoggedRelations)
            &&
            !empty($this->toBeLoggedRelations)
        ) {
            $relationsChanges = [];
            foreach ($this->toBeLoggedRelations as $relation) {
                $changes = $this->{$relation}->getChangedAttributes();
                if(Arr::has($changes, ['old', 'new'])) {
                    $relationsChanges['old'] = $changes['old'];
                    $relationsChanges['new'] = $changes['new'];
                }
            }

            return array_merge_recursive(self::$changedAttributes, $relationsChanges);
        }

        return self::$changedAttributes;
    }

    /**
     * Method to log an action
     *
     * @param string $action
     * @param string $description
     * @return mixed
     */
    public function log(string $action, string $description = '')
    {
        return Log::log($this, $this->id, $action, $description, $this->getChangedAttributes());
    }

    /**
     * Logs relationship
     * @return Builder
     */
    public static function logHistory(): Builder
    {
        return Log::forSubject(self::getModel());
    }
}
