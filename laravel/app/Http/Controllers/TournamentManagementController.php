<?php
// app/Http/Controllers/Admin/TournamentManagementController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;

class TournamentManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $tournaments = Tournament::with('game', 'organizer')
                                 ->withCount('registrations')
                                 ->latest()
                                 ->paginate(20);

        return view('admin.tournaments.index', compact('tournaments'));
    }

    public function registrations($id)
    {
        $tournament = Tournament::with('game')->findOrFail($id);
        $registrations = TournamentRegistration::where('tournament_id', $id)
                                               ->with('team.captain')
                                               ->latest()
                                               ->paginate(20);

        return view('admin.tournaments.registrations', compact('tournament', 'registrations'));
    }

    public function approveRegistration($id)
    {
        $registration = TournamentRegistration::findOrFail($id);
        $registration->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Registration approved successfully!');
    }

    public function rejectRegistration($id)
    {
        $registration = TournamentRegistration::findOrFail($id);
        $registration->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Registration rejected!');
    }

    public function updateStatus(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:draft,registration_open,registration_closed,ongoing,completed,cancelled',
        ]);

        $tournament->update(['status' => $request->status]);

        return back()->with('success', 'Tournament status updated successfully!');
    }
}
