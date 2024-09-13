<?php

namespace App\Http\Controllers\Callbacks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JoinTelegramController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        auth()->user()->update(['telegram_id' => $request->get('id')]);
        return redirect()->back();
    }
}
