<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueAcrossTables implements Rule
{
    protected $parameters;
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param array $parameters [
     *      'tables' => ['table1', 'table2'],
     *      'exclude_id' => null,
     *      'exclude_table' => null,
     *      'id_column' => 'id',
     * ]
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->message = '';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->parameters['tables'] as $table) {
            if ( $this->recordExists($attribute, $value, $table)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if a record exists for a given attribute, value, and table.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  string  $table
     * @return bool
     */
    protected function recordExists($attribute, $value, $table)
    {
        $query = DB::table($table)->where($attribute, '=', $value);

        if ($this->shouldExcludeFromTable($table)) {
            $query->where($this->parameters['id_column'], '<>', $this->parameters['exclude_id']);
        }

        return $query->exists();
    }

    /**
     * Determine if we should exclude a specific ID from the check for a given table.
     *
     * @param  string  $table
     * @return bool
     */
    protected function shouldExcludeFromTable($table)
    {
        return $this->parameters['exclude_table'] === $table && $this->parameters['exclude_id'] !== null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message ?: __('validation.unique' );
    }
}


