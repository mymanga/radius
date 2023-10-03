<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\EmailConversation;

class SupportComposer
{
    public function compose(View $view)
    {
        $unreadCount = EmailConversation::where('is_read', false)->count();
        $view->with('unreadCount', $unreadCount);
    }
}