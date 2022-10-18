<?php

namespace App\Http\Livewire\Settings;

use App\Models\Currency;
use App\Models\Customer;
use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Models\Warehouse;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;

    public $settings;

    public $listeners = ['update'];
    
    public array $listsForFields = [];

    public array $rules = [
        'settings.company_name' => 'required|string|min:1|max:255',
        'settings.company_email' => 'required|string|min:1|max:255',
        'settings.company_phone' => 'required|string|min:1|max:255',
        'settings.site_logo' => 'nullable|string|min:0|max:255',
        'settings.default_currency_id' => 'required|integer|min:0|max:4294967295',
        'settings.default_currency_position' => 'required|string|min:1|max:255',
        'settings.notification_email' => 'required|string|min:1|max:255',
        'settings.footer_text' => 'required|string|min:1|max:255',
        'settings.company_address' => 'required|string|min:1|max:255',
        'settings.default_client_id' => 'nullable|integer|min:0|max:4294967295',
        'settings.default_warehouse_id' => 'nullable|integer|min:0|max:4294967295',
        'settings.default_language' => 'required|string|min:1|max:255',
        'settings.is_invoice_footer' => 'boolean',
        'settings.invoice_footer' => 'nullable|string|min:0|max:255',
        'settings.company_tax' => 'nullable|string|min:0|max:255',
        'settings.is_rtl' => 'boolean',
        'settings.invoice_prefix' => 'required|string|min:1|max:255',
        'settings.show_email' => 'boolean',
        'settings.show_address' => 'boolean',
        'settings.show_order_tax' => 'boolean',
        'settings.show_discount' => 'boolean',
        'settings.show_shipping' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.settings.index');
    }

    public function mount() {
        abort_if(Gate::denies('access_settings'), 403);

        $settings = Setting::firstOrFail();

        $this->settings = $settings;

        $this->initListsForFields();
    }

    public function update() {
        $this->validate();

        $this->settings->save();

        cache()->forget('settings');

        $this->alert('success', 'Settings Updated!');
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['currencies'] = Currency::pluck('name', 'id')->toArray();
        $this->listsForFields['warehouses'] = Warehouse::pluck('name', 'id')->toArray();
        $this->listsForFields['customers'] = Customer::pluck('name', 'id')->toArray();
    }

    
}