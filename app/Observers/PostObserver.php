<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
   public function deleted(Post $post)
   {
   		$post->comments->each->delete();
   }
}
