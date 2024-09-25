<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\AlertUser;

class AlertUserController extends Controller
{
    public function show()
    {

            $id = Auth::id();

            // Fetch all alerts
            $alerts = Alert::all();

            if ($alerts->isEmpty()) {
                return response()->json(['error' => 'No alerts found'], 422);
            }

            $result = [];

            foreach ($alerts as $alert) {
                // Fix the typo 'whrere' to 'where'
                $alertUser = AlertUser::where('user_id', $id)
                                      ->where('alert_id', $alert->id)
                                      ->first();

                if (!$alertUser) {
                    $createData = [
                        'user_id' => $id,
                        'alert_id' => $alert->id
                    ];

                    // Use try-catch to handle potential exceptions
                    try {
                        $createdAlertUser = AlertUser::create($createData);

                        if (!$createdAlertUser) {
                            return response()->json(['error' => 'Failed to create alert user record'], 422);
                        }

                        $result[] = [
                            'id' => $alert->id,
                            'message' => $alert->message
                        ];
                    } catch (\Exception $e) {
                        return response()->json(['error' => 'Error creating alert user: ' . $e->getMessage()], 422);
                    }
                }
            }


            return response()->json($result, 200);
        }
}

