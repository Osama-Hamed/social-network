<?php

namespace App\Traits;

use Carbon\Carbon;

trait Friendable
{
	public function friendsSentRequest()
    {
        return $this->belongsToMany(self::class, 'friendships', 'reciever_id', 'sender_id')
            ->withPivot('accepted_at')
            ->whereNotNull('accepted_at');
    }

    public function friendsRecievedRequest()
    {
        return $this->belongsToMany(self::class, 'friendships', 'sender_id', 'reciever_id')
            ->withPivot('accepted_at')
            ->whereNotNull('accepted_at');
    }

    public function friends()
    {
        return $this->friendsRecievedRequest->merge($this->friendsSentRequest);
    }

    public function isFriendOf($user)
    {
        return $this->friendsSentRequest()->where('sender_id', $user->id)->exists() ||
            $this->friendsRecievedRequest()->where('reciever_id', $user->id)->exists();
    }

    public function usersSentRequest()
    {
        return $this->belongsToMany(self::class, 'friendships', 'reciever_id', 'sender_id')
            ->withPivot('accepted_at')
            ->whereNull('accepted_at');
    }

    public function usersRecievedRequest()
    {
        return $this->belongsToMany(self::class, 'friendships', 'sender_id', 'reciever_id')
            ->withPivot('accepted_at')
            ->whereNull('accepted_at');
    }

    public function hasFriendRequestFrom($user)
    {
        return $this->usersSentRequest()->where('sender_id', $user->id)->exists();
    }

    public function sentFriendRequestTo($user)
    {
        return $this->usersRecievedRequest()->where('reciever_id', $user->id)->exists();
    }

    public function sendFriendRequest($user)
    {
        if (!$this->isFriendOf($user) && !$this->hasFriendRequestFrom($user) && !$this->sentFriendRequestTo($user) && $this->isNot($user)) {
            $this->usersRecievedRequest()->attach($user);
        }
    }

    public function cancelFriendRequest($user)
    {
        $this->usersSentRequest()->detach($user);
        $this->usersRecievedRequest()->detach($user);
    }

    public function addFriend($user)
    {
        if ($this->hasFriendRequestFrom($user)) {
            $this->usersSentRequest()->updateExistingPivot($user, ['accepted_at' => Carbon::now()]);
        }

        if ($this->sentFriendRequestTo($user)) {
            $this->usersRecievedRequest()->updateExistingPivot($user, ['accepted_at' => Carbon::now()]);
        }
    }

    public function unfriend($user)
    {
        $this->friendsSentRequest()->detach($user);
        $this->friendsRecievedRequest()->detach($user);
    }
}