<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelUserController extends Controller
{

    public function show(Channel $channel, Request $request)
    {
        $config = $channel->type->config();
        $classname = $config['repository'];
        if (! $classname) {
            abort(404);
        }
        $repository = app($classname);
        return $repository->getUser($channel, $request->user()->id);
    }
}
