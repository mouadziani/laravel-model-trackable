<?php

namespace Mouadziani\Traits;

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
        parent::boot();

        static::updated(function ($model) {
            self::$changedAttributes['old'] = Arr::only($model->getRawOriginal(), array_keys($model->changes));
            self::$changedAttributes['new'] = $model->changes;
        });
    }

    /**
     * Get array of changed attributes
     *
     * @return array
     */
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
                $relationsChanges['old'][$relation] = $changes['old'];
                $relationsChanges['new'][$relation] = $changes['new'];
            }
            return array_merge_recursive(self::$changedAttributes, $relationsChanges);
        }
        return self::$changedAttributes;
    }
}
