<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function blocked(): View //tijdelijk
    {   
        return view('blocked');
    }

    public function blockUser(User $user): RedirectResponse
    {   
        $user->update([
            'blocked' => true]);
            
        return redirect()->route('dashboard')->with('success', 'User blocked successfully!');
    }

    public function unblockUser(User $user): RedirectResponse
    {   
        $user->update([
            'blocked' => false]);
            
        return redirect()->route('dashboard')->with('success', 'User unblocked successfully!');
    }
}
