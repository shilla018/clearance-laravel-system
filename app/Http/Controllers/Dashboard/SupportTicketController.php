<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SystemNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportTicketController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = SupportTicket::with(['student', 'admin'])->latest();

        if ($user->isStudent()) {
            $query->where('user_id', $user->id);
        }

        return view('dashboard.support.index', [
            'tickets' => $query->paginate(12),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'priority' => ['required', 'in:low,normal,high'],
        ]);

        $ticket = SupportTicket::create([
            'user_id' => $request->user()->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        return redirect()->route('dashboard.support.show', $ticket)->with('success', 'Your support request has been submitted.');
    }

    public function show(Request $request, SupportTicket $ticket): View
    {
        $this->authorizeTicket($request, $ticket);

        return view('dashboard.support.show', [
            'ticket' => $ticket->load(['student', 'admin']),
        ]);
    }

    public function respond(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'admin_feedback' => ['required', 'string', 'max:2000'],
            'status' => ['required', 'in:open,in_progress,resolved'],
        ]);

        $ticket->update([
            'assigned_to' => $request->user()->id,
            'admin_feedback' => $validated['admin_feedback'],
            'status' => $validated['status'],
            'responded_at' => now(),
            'resolved_at' => $validated['status'] === 'resolved' ? now() : null,
        ]);

        SystemNotification::create([
            'user_id' => $ticket->user_id,
            'title' => 'Support feedback received',
            'message' => 'Admin feedback is available for your support request: '.$ticket->subject,
            'type' => 'support',
            'action_url' => route('dashboard.support.show', $ticket),
        ]);

        return back()->with('success', 'Feedback has been sent to the student.');
    }

    private function authorizeTicket(Request $request, SupportTicket $ticket): void
    {
        $user = $request->user();

        if ($user->isStudent() && $ticket->user_id !== $user->id) {
            abort(403);
        }
    }
}
