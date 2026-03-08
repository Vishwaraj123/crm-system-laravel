<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMode;
use App\Models\Proposal;

class DashboardController extends Controller
{
    public function index()
    {
        $invoiceStatuses  = ['draft', 'pending', 'overdue', 'paid', 'unpaid', 'partially'];
        $proposalStatuses = ['draft', 'pending', 'sent', 'accepted', 'declined', 'cancelled'];

        $invoiceCounts = [];
        foreach ($invoiceStatuses as $s) {
            $invoiceCounts[$s] = Invoice::where('status', $s)->count();
        }

        $proposalCounts = [];
        foreach ($proposalStatuses as $s) {
            $proposalCounts[$s] = Proposal::where('status', $s)->count();
        }

        $invoiceTotal  = max(Invoice::count(), 1);
        $proposalTotal = max(Proposal::count(), 1);
        $clientTotal   = max(Client::count(), 1);
        $activeClients = Client::where('removed', false)->count();

        $stats = [
            'invoice_counts'     => $invoiceCounts,
            'invoice_total'      => Invoice::count(),
            'proposal_counts'    => $proposalCounts,
            'proposal_total'     => Proposal::count(),
            'clients_total'      => Client::count(),
            'new_clients_month'  => Client::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)->count(),
            'active_clients'     => $activeClients,
            'active_pct'         => round(($activeClients / $clientTotal) * 100, 2),
            'payments'           => Payment::count(),
            'payment_modes'      => PaymentMode::count(),
            'recent_invoices'    => Invoice::with('client')->latest()->take(5)->get(),
            'recent_proposals'   => Proposal::with('client')->latest()->take(5)->get(),
            'invoice_total_val'  => Invoice::sum('total'),
            'proposal_total_val' => Proposal::sum('total'),
        ];

        return view('dashboard', compact('stats', 'invoiceTotal', 'proposalTotal'));
    }
}
