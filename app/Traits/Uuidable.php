<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuidable
{
    public $uuidColumn = 'uuid';

    /**
     * Add createUuid method to boot
     *
     * @return void
     */
    protected static function bootUuidable()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::orderedUuid();
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return $this->uuidColumn;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
