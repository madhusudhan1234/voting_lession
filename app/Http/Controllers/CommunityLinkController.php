<?php

namespace App\Http\Controllers;

use App\Channel;
use App\CommunityLink;
use App\Exceptions\CommunityLinkAlreadySubmitted;
use App\Http\Requests\CommunityLinkForm;
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
     * Index view return with some $links and $channels
     *
     * @return mixed
     */
    public function index(Channel $channel = null)
    {
        $links = CommunityLink::forChannel($channel)
            ->where('approved', '1')
            ->latest()
            ->paginate(3);

        $channels = Channel::orderBy('title', 'asc')->get();

        return view('community.index', compact('links', 'channels','channel'));
    }

    /**
     * Publish the Community Link
     *
     * @param CommunityLinkForm $request
     * @return mixed
     */
    public function store(CommunityLinkForm $form)
    {
        try {

            $form->persist();
            if (auth()->user()->isTrusted()) {
                flash('Thanks For the Contribution !', 'success');
            } else {
                flash()->overlay('This contribution will be approved shortly !');
            }

        } catch (CommunityLinkAlreadySubmitted $e) {
            flash()->overlay(
                "we'll instead bump the timestamp and bring that link back to the top, Thanks !",
                'That link has been already Submitted'
            );
        }

        return back();
    }
}
