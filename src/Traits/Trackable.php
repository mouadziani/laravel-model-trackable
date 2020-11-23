<?php

namespace LaravelModelTrackable\Traits;

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
            $changedFields = array_keys(Arr::except($model->getChanges(), 'updated_at'));
            self::$changedAttributes['old'] = Arr::only($model->getRawOriginal(), $changedFields);
            self::$changedAttributes['new'] = $model->changes;
        });
    }

    public function getChangedAttributes() {
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
}
