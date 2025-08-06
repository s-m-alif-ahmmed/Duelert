<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\CredentialSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class StripeSettingController extends Controller {
    /**
     * Display stripe settings page.
     *
     * @return View
     */
    public function index(): View {
        return view('backend.layouts.settings.paystack_settings');
    }
    /**
     * Display stripe settings page.
     *
     * @return View
     */
    public function google(): View {
        return view('backend.layouts.settings.google_settings');
    }

    public function edit()
    {
        // Retrieve the first policy entry or create a new instance if none exists
        $credential = CredentialSetting::first() ?? new CredentialSetting();
        return view('backend.layouts.credential', compact('credential'));
    }

    public function update(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'callback_url' => 'nullable|string',
            'paystack_public_key' => 'nullable|string',
            'paystack_secret' => 'nullable|string',
        ]);

        // Retrieve or create the policy record
        $credential = CredentialSetting::first() ?? new CredentialSetting();

        // Update policy content
        $credential->callback_url = $request->callback_url;
        $credential->paystack_public_key = $request->paystack_public_key;
        $credential->paystack_secret_key = $request->paystack_secret;
        $credential->save();

        // Update .env file
        $this->updateEnv([
            'PAYSTACK_CALLBACK_URL' => $request->callback_url,
            'PAYSTACK_PUBLIC_KEY' => $request->paystack_public_key,
            'PAYSTACK_SECRET' => $request->paystack_secret,
        ]);

        // Clear cache for changes to take effect
        Artisan::call('config:clear');

        // Redirect back with success message
        return back()->with('t-success', 'Credentials successfully updated');
    }

    // Private function to update .env datas
    private function updateEnv($data)
    {
        $envPath = base_path('.env');

        if (File::exists($envPath)) {
            $envContent = File::get($envPath);

            foreach ($data as $key => $value) {
                $pattern = "/^{$key}=.*/m";
                $replacement = "{$key}={$value}";

                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, $replacement, $envContent);
                } else {
                    $envContent .= "\n{$key}={$value}";
                }
            }

            File::put($envPath, $envContent);
        }
    }

}
