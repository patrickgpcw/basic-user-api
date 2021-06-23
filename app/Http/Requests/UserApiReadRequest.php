<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\PageLimit;
use Illuminate\Foundation\Http\FormRequest;

class UserApiReadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $quantity = $this->input('exibir', config('api.quantity'));
        $userTotal = User::count();

        $this->merge([
            'user_total' => $userTotal,
        ]);

        return [
            'nome' => ['nullable', 'string', 'max:30'],
            'pagina' => ['nullable', 'integer', 'min:1', new PageLimit($quantity, $userTotal)],
            'exibir' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
