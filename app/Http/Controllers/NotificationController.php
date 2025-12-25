<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get unread notifications for the navbar
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        if (!$user) return response()->json(['count' => 0]);

        return response()->json([
            'count' => $user->unreadNotifications->count()
        ]);
    }

    /**
     * Get latest notifications list (HTML)
     */
    public function getDropdownList()
    {
        $user = Auth::user();
        if (!$user) return '';

        $notifications = $user->notifications()->take(5)->get();

        $html = '';
        if ($notifications->count() == 0) {
            $html .= '<span class="dropdown-item dropdown-header">Tidak ada notifikasi baru</span>';
        } else {
            foreach ($notifications as $n) {
                // Determine icon based on type (simple logic)
                $icon = 'fas fa-envelope';
                $bg = 'text-primary';

                if (str_contains($n->type, 'Izin')) {
                    $icon = 'fas fa-file-medical';
                    $bg = 'text-warning';
                }
                if (str_contains($n->type, 'Lembur')) {
                    $icon = 'fas fa-clock';
                    $bg = 'text-info';
                }
                if (str_contains($n->type, 'Dinas')) {
                    $icon = 'fas fa-plane';
                    $bg = 'text-success';
                }
                if (str_contains($n->type, 'Payroll')) {
                    $icon = 'fas fa-money-bill';
                    $bg = 'text-success';
                }

                $title = $n->data['title'] ?? 'Notifikasi';
                $time = $n->created_at->diffForHumans();

                // If unread, slightly bolder
                $style = $n->read_at ? '' : 'background-color: #f4f6f9;';

                $html .= '<a href="#" class="dropdown-item" style="' . $style . '">
                    <i class="' . $icon . ' mr-2 ' . $bg . '"></i> ' . $title . '
                    <span class="float-right text-muted text-sm">' . $time . '</span>
                </a>
                <div class="dropdown-divider"></div>';
            }
            $html .= '<a href="' . route('notifications.index') . '" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>';
        }

        return $html;
    }

    /**
     * Index page for all notifications
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(20);

        // Mark as read when opening index? Or explicit?
        // Let's just keep them as is until clicked or explicit "Mark all read"

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark all as read
     */
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
