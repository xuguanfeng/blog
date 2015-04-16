<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Http\Models\Admin\Page;

class StoreBlogPostRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
//        var_dump($this->route("id"));
//        $this->route("id");
//        var_dump(Page::find(Request::input('id'))->user_id);
//
//        var_dump(Auth::user()->id);
//        return Page::find(Request::input('id'))->user_id == Auth::user()->id;
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'title' => 'required|max:255',
            'body' => 'required',
		];
	}

}
