<?php

namespace App\Traits;

trait Uuid
{
    /**
     * Create random uuid in model
     */
    public static function bootUuid()
    {
        static::creating(function ($model) {
            $uuidFieldName = $model->getUuidFieldName();
            if (empty($model->$uuidFieldName)) {
                $model->$uuidFieldName = static::generateUUID();
            }
        });
    }

    /**
     * Get uuid fieldname in database
     * @return string fieldname
     */
    public function getUuidFieldName()
    {
        if (!empty($this->uuidFieldName)) {
            return $this->uuidFieldName;
        }
        return 'uuid';
    }

    /**
     * Generate uuid version 4
     * @return string uuid
     */
    public static function generateUUID()
    {
        return \Uuid::generate(4)->string;
    }

    /**
     * Add Scope by uuid to eleoquent ORM
     */
    public function scopeUuid($query, $uuid, $first = true)
    {
        $match = preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $uuid);

        if (!is_string($uuid) || $match !== 1) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }

        $results = $query->where($this->getUuidFieldName(), $uuid);
        return $first ? $results->firstOrFail() : $results;
    }
}
