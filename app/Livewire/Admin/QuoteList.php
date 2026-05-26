<?php

namespace App\Livewire\Admin;

use App\Models\Quote;
use Livewire\Component;
use Livewire\WithPagination;

class QuoteList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $statusFilter = '';

    protected $paginationTheme = 'tailwind';

    public function updateQuoteStatus($quoteId, $status)
    {
        $quote = Quote::find($quoteId);
        if ($quote) {
            $quote->status = $status;
            $quote->save();
            session()->flash('message', 'Statut du devis mis à jour avec succès.');
        }
    }

    public function updateQuoteNotes($quoteId, $notes)
    {
        $quote = Quote::find($quoteId);
        if ($quote) {
            $quote->admin_notes = $notes;
            $quote->save();
            session()->flash('message', 'Notes admin mises à jour avec succès.');
        }
    }

    public function updateQuoteAmount($quoteId, $amount)
    {
        $quote = Quote::find($quoteId);
        if ($quote) {
            $quote->estimated_amount = $amount;
            $quote->save();
            session()->flash('message', 'Montant estimé mis à jour avec succès.');
        }
    }

    public function render()
    {
        $quotes = Quote::with('user')
            ->when($this->search, function ($query) {
                $query->where('contact_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('company_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.quote-list', [
            'quotes' => $quotes
        ])->layout('layouts.admin', ['title' => 'Gestion des Devis']);
    }
}
