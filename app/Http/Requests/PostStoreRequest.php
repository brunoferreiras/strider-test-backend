<?php

namespace App\Http\Requests;

use App\Repositories\PostRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $total = app()->make(PostRepository::class)->getTotalPostsToday(request()->post('user_id'));
        return $total <= 5;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string|max:777',
            'user_id' => 'required|exists:users,id'
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('You can\'t create more than 5 posts per day.');
    }
}
