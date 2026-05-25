<?php

namespace App\Livewire;

use Livewire\Component;

class ToastNotification extends Component
{
    public $show = false;
    public $message = '';
    public $type = 'success';

    protected $listeners = ['showToast'];

    public function showToast($message, $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->show = true;

        // Auto hide after 3 seconds
        $this->dispatch('closeToast');
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.toast-notification');
    }
}
