<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait Sortable
{
    /**
     * @param Builder $builder
     * @param string|null $column
     * @param bool $isDesc
     * @return void
     */
    public function scopeSort(Builder $builder, ?string $column, bool $isDesc)
    {
        $direction = $isDesc ? 'desc' : 'asc';
        if (! empty($column) && Schema::hasColumn($this->getTable(), $column)) {
            $builder->orderBy($column, $direction);
        } elseif (Schema::hasColumn($this->getTable(), 'created_at')) {
            $builder->orderBy('created_at', $direction);
        }
    }
}
