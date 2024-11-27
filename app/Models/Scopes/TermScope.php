<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TermScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    protected $termId;

    public function __construct($termId)
    {
        $this->termId = $termId;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('term_id', $this->termId);
    }
}
