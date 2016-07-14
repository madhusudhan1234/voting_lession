<?php

namespace App\Http\Controllers;

use App\Channel;
use App\CommunityLink;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommunityLinkController
 * @package App\Http\Controllers
 */
class CommunityLinkController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $links = CommunityLink::where('approved','1')->paginate(25);
        $channels = Channel::orderBy('title','asc')->get();
        
        return view('community.index',compact('links','channels'));
    }

    /**
     * Publish the Community Link
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'channel_id' => 'required |exists:channels,id',
           'title' => 'required',
            'link' => 'required|active_url|unique:community_links'
        ]);
        
        CommunityLink::from(Auth::user())
            ->contribute($request->all());

        if(auth()->user()->isTrusted()){
            flash('Thanks For the Contribution !','success');
        }else{
            flash()->overlay('This contribution will be approved shortly !');
        }
        
        return back();
    }
}
