<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseDetailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Split amount between users
     * 
     * method that calculates the amount to be split between users
     * 
     * @param  [string] type
     * @param  [float] amount
     * @param  [array] splitBetween
     * @return [float] amount
     */
    private function splitAmount(ExpenseRequest $request, $splitBetween)
    {
        if ($type == 'equal') {
            return number_format(floor($amount / count($splitBetween)*100)/100,2,'.','');
        } else if ($type == 'percentage') {
            return ($amount * $splitBetween['percentage']) / 100;
        } else {
            return $splitBetween['amount'];
        }
    }

    /**
     * Build split between array
     * 
     * method that builds the split between array to insert into the database
     * 
     * @param  [string] type
     * @param  [float] amount
     * @param  [array] splitBetween
     * @return [ExpenseRequest] request
     */
    private function buildSplitBetween(ExpenseRequest $request)
    {
        $request->merge([
            'splitBetween' => array_map(function ($user) use ($request) {
                return [
                    'user_id' => $user['user_id'],
                    'amount' => $this->splitAmount($request, $user)
                ];
            }, $request->splitBetween)
        ]);

        return $request;
    }

    /**
     * Create expense
     * 
     * method that creates an expense and splits it between users for details
     * 
     * @param  [string] name
     * @param  [float] amount
     * @param  [string] description
     * @param  [string] type
     * @param  [array] splitBetween
     * @return [json] array
     */
    public function create(ExpenseRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $expense = $request->user()->expenses()->create([
                    'name' => $request->name,
                    'amount' => $request->amount,
                    'description' => $request->description ?? '',
                    'type' => $request->type,
                ]);

                $request = $this->buildSplitBetween($request);
                $expense->details()->createMany($request->splitBetween);
                $totalCalculated = $expense->amountFromDetail();
                $totalAmountInPaise = $expense->amount * 100;

                if ($totalCalculated > $totalAmountInPaise) {
                    throw new \Exception(
                        'Total amount calculated is greater than total amount, Something went wrong!'
                    );
                } else if ($totalCalculated < $totalAmountInPaise) {
                    $expense->details()->first()->increment(
                        'amount', $totalAmountInPaise - $totalCalculated
                    );
                }
        
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully created expense!',
                    'data' => new ExpenseResource($expense)
                ], 201);
            });
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create expense!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * get expenses
     * 
     * @return [json] array
     */
    public function getExpenses()
    {
        $user = auth()->user();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched expenses!',
            'data' => ExpenseResource::collection($user->expenses)
        ], 200);
    }

    /**
     * get expense
     * 
     * @param  [int] expenseId
     * @return [json] array
     */
    public function getExpense($expenseId)
    {
        $user = auth()->user();

        $expense = $user->expenses()->where('id', $expenseId)->first();

        if (!$expense) {
            return response()->json([
                'status' => false,
                'message' => 'Expense not found!',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched expense!',
            'data' => $expense
        ], 200);
    }

    /**
     * get outstandings
     * 
     * @return [json] array
     */
    public function getOutstandings()
    {
        $user = auth()->user();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched outstandings!',
            'data' => [
                'outstanding' => $user->total_outstanding,
                'outstanding_details' => ExpenseDetailResource::collection(
                    $user->expenseDetails
                ),
            ]
        ], 200);
    }
}
