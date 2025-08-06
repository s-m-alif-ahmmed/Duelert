<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Twillio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class TwillioController extends Controller
{
    public function index(): View
    {
        return view('backend.layouts.settings.twillio_settings');
    }

    public function update(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'twilio_sid' => 'nullable|string',
            'twilio_auth_token' => 'nullable|string',
            'twilio_from' => 'nullable|string',
        ]);

        // Retrieve or create the policy record
        $credential = Twillio::first() ?? new Twillio();

        // Update policy content
        $credential->twilio_sid = $request->twilio_sid;
        $credential->twilio_auth_token = $request->twilio_auth_token;
        $credential->twilio_from = $request->twilio_from;
        $credential->save();

        // Update .env file
        $this->updateEnv([
            'TWILIO_SID' => $request->twilio_sid,
            'TWILIO_AUTH_TOKEN' => $request->twilio_auth_token,
            'TWILIO_FROM' => $request->twilio_from,
        ]);

        // Clear cache for changes to take effect
        Artisan::call('config:clear');

        // Redirect back with success message
        return back()->with('t-success', 'Twilio Settings successfully updated!');
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
