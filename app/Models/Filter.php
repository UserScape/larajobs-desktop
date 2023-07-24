<?php

namespace App\Models;

use App\Enums\FilterField;
use App\Enums\FilterOperation;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $casts = [
        'field' => FilterField::class,
        'operation' => FilterOperation::class,
    ];

    protected $fillable = [
        'field',
        'operation',
        'query',
    ];

    /**
     * Transforms the filter to a query arguments
     */
    public function operationToQuery()
    {
        $value = $this->query;

        switch ($this->operation) {
            case FilterOperation::Equals:
                return '=';
            case FilterOperation::NotEquals:
                return '!=';
            case FilterOperation::Contains:
                $value = "%{$value}%";
                return 'LIKE';
            case FilterOperation::NotContains:
                $value = "%{$value}%";
                return 'NOT LIKE';
        }

        return [
            'field' => $this->field,
            'operator' => $this->operation,
            'value' => $value,
        ];
    }
}
