<?php

namespace App\Http\Requests;

use App\CommunityLink;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CommunityLinkForm extends Request
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
        return [
            'channel_id' => 'required |exists:channels,id',
            'title' => 'required',
            'link' => 'required|active_url'
        ];
    }

    /*
     * Persist the Community Link Submission Form
     */
    public function persist()
    {
        CommunityLink::from(Auth::user())
            ->contribute($this->all());
    }
}
