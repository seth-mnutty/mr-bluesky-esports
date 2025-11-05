<?php
// app/Http/Controllers/Admin/UserManagementController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $users = User::withCount(['teams', 'organizedTournaments'])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with([
            'teams',
            'organizedTournaments',
            'gameReviews',
            'playerPerformances'
        ])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|in:admin,organizer,player,spectator',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'User role updated successfully!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'User status updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin users!');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }
}