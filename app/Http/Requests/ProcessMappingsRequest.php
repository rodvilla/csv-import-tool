<?php

namespace App\Http\Requests;

use App\Rules\ContainsRequiredFields;
use App\Rules\FileExists;
use App\Traits\AuthorizedRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProcessMappingsRequest extends FormRequest
{
    use AuthorizedRequest;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mappings' => ['required', 'array', new ContainsRequiredFields],
            'path'     => ['required', new FileExists]
        ];
    }
}
