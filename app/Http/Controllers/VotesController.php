<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CommunityLink;
use App\CommunityLinkVote;

class VotesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function store(CommunityLink $link)
    {
    	auth()->user()->togglevoteFor($link);
    	return back();
    }
}
