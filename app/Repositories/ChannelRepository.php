<?php

namespace App\Repositories;

use App\Data\User;

interface ChannelRepository
{
    /**
     * Fetch a user from a channel and return a User object.
     *
     * @param $channel
     * @param $id
     * @return \App\Data\User
     */
    public function getUser($channel, $id): User|null;
}
