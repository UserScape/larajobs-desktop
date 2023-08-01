<?php

namespace App\Models;

use App\Enums\FilterField;
use App\Enums\FilterOperation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Filter extends Model
{
    use HasFactory;

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
     * Get the field name as a human readable string
     */
    public function getFriendlyField(): string
    {
        return Str::ucfirst($this->field->value);
    }

    /**
     * Get the operation as a human readable string
     */
    public function getFriendlyOperation(): string
    {
        switch ($this->operation) {
            case FilterOperation::Equals:
                return 'equals';
            case FilterOperation::NotEquals:
                return 'isn\'t equal to';
            case FilterOperation::Contains:
                return 'contains';
            case FilterOperation::NotContains:
                return 'doesn\'t contain';
            default:
                return $this->operation;
        }
    }

    /**
     * Transforms the filter to a query arguments
    */
    public function operationToQuery()
    {
        $value = $this->query;

        switch ($this->operation) {
            case FilterOperation::Equals:
                $operation = '=';
                break;
            case FilterOperation::NotEquals:
                $operation = '!=';
                break;
            case FilterOperation::Contains:
                $value = "%{$value}%";
                $operation = 'LIKE';
                break;
            case FilterOperation::NotContains:
                $value = "%{$value}%";
                $operation = 'NOT LIKE';
                break;
            default:
                $operation = $this->operation;
        }

        return [
            $this->field->value,
            $operation,
            $value,
        ];
    }
}
