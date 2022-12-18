<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get user
     *
     * @return [json] array
     */
    public function getUser(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched user!',
            'data' => auth()->user()
        ], 200);
    }

    /**
     * Get outstandings
     *
     * @return [json] array
     */
    public function getOutStandings()
    {
        $user = auth()->user();

        $outStandings = $user->expenseDetails;

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched outstandings!',
            'data' => [
                'outstandings' => $outStandings,
                'total' => $user->total_outstanding,
            ]
        ], 200);
    }
}
