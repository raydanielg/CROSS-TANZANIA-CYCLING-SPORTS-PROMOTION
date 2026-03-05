<?php

use App\Models\User;
use App\Models\Event;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- Cross Tanzania Registration Test ---\n";

// 1. Hakikisha tuna Event ya upcoming
$event = Event::where('status', 'upcoming')->first();
if (!$event) {
    echo "Creating a test upcoming event...\n";
    $event = Event::create([
        'name' => 'Test Event ' . rand(),
        'slug' => 'test-event-' . rand(),
        'status' => 'upcoming',
        'event_date' => now()->addDays(10),
        'registration_fee' => 10000,
    ]);
}
echo "Using Event ID: {$event->id}\n";

// 2. Safisha data ya zamani ya testrider
$testEmail = 'testrider@example.com';
User::where('email', $testEmail)->delete();
echo "Cleaned up old test user: {$testEmail}\n";

// 3. Tengeneza Request ya usajili
$data = [
    'name' => 'Test Rider',
    'email' => $testEmail,
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'phone' => '0712345678',
    'gender' => 'Male',
    'date_of_birth' => '1995-05-10',
    'emergency_contact_name' => 'John Doe',
    'emergency_contact_phone' => '0788123456',
    'role' => 'rider'
];

echo "Submitting registration for: {$testEmail}\n";

$request = Request::create('/api/register', 'POST', $data);
$request->headers->set('Accept', 'application/json');

try {
    $controller = app()->make(RegisterController::class);
    $response = $controller->register($request);
    
    echo "Status Code: " . $response->getStatusCode() . "\n";
    echo "Response Body:\n";
    echo json_encode(json_decode($response->getContent()), JSON_PRETTY_PRINT) . "\n";

    if ($response->getStatusCode() === 201) {
        echo "\nSUCCESS: Rider registered and linked to event!\n";
        
        // 4. Verify in database
        $user = User::where('email', $testEmail)->with('participant.registrations')->first();
        if ($user && $user->participant && $user->participant->registrations->count() > 0) {
            echo "Verification: User exists with Role '{$user->role}' and has " . $user->participant->registrations->count() . " registration(s).\n";
        }
    } else {
        echo "\nFAILED: Check the errors above.\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
echo "--- Test Finished ---\n";
