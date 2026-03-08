<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Currency options: code => [symbol, name]
    const CURRENCIES = [
        'USD' => ['$',  'USD — US Dollar'],
        'EUR' => ['€',  'EUR — Euro'],
        'GBP' => ['£',  'GBP — British Pound'],
        'INR' => ['₹',  'INR — Indian Rupee'],
        'AUD' => ['A$', 'AUD — Australian Dollar'],
        'CAD' => ['C$', 'CAD — Canadian Dollar'],
        'AED' => ['د.إ','AED — UAE Dirham'],
        'SAR' => ['﷼',  'SAR — Saudi Riyal'],
        'JPY' => ['¥',  'JPY — Japanese Yen'],
        'CNY' => ['¥',  'CNY — Chinese Yuan'],
        'SGD' => ['S$', 'SGD — Singapore Dollar'],
        'CHF' => ['Fr', 'CHF — Swiss Franc'],
    ];

    const DATE_FORMATS = [
        'd/m/Y' => 'DD/MM/YYYY (e.g. 08/03/2026)',
        'm/d/Y' => 'MM/DD/YYYY (e.g. 03/08/2026)',
        'Y-m-d' => 'YYYY-MM-DD (e.g. 2026-03-08)',
        'd-M-Y' => 'DD-Mon-YYYY (e.g. 08-Mar-2026)',
        'd M Y' => 'DD Mon YYYY (e.g. 08 Mar 2026)',
        'F j, Y' => 'Month DD, YYYY (e.g. March 8, 2026)',
    ];

    public function index()
    {
        $settings    = Setting::allAsArray();
        $currencies  = self::CURRENCIES;
        $dateFormats = self::DATE_FORMATS;
        return view('settings.index', compact('settings', 'currencies', 'dateFormats'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name'       => 'nullable|string|max:150',
            'company_address'    => 'nullable|string|max:255',
            'company_state'      => 'nullable|string|max:100',
            'company_country'    => 'nullable|string|max:100',
            'company_email'      => 'nullable|email|max:150',
            'company_phone'      => 'nullable|string|max:30',
            'company_website'    => 'nullable|url|max:200',
            'company_tax_number' => 'nullable|string|max:60',
            'company_logo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'default_currency'   => 'nullable|string|max:10',
            'date_format'        => 'nullable|string|max:20',
        ]);

        $keys = [
            'company_name', 'company_address', 'company_state', 'company_country',
            'company_email', 'company_phone', 'company_website', 'company_tax_number',
            'default_currency', 'date_format',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        // Update currency symbol automatically based on selected currency
        if ($request->filled('default_currency')) {
            $symbol = self::CURRENCIES[$request->default_currency][0] ?? $request->default_currency;
            Setting::set('currency_symbol', $symbol);
        }

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo
            $oldLogo = Setting::get('company_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('company_logo')->store('logos', 'public');
            Setting::set('company_logo', $path);
        }

        return redirect()->route('settings.index')->with('success', 'Settings saved successfully.');
    }
}
