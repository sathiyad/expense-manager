<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->route()->getName() === 'expense.outstanding') {
            return [
                'id' => $this->id,
                'amount' => $this->amount,
                'paid_at' => $this->paid_at,
                'created_at' => $this->created_at,
            ];
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'amount' => $this->amount,
            'paid_at' => $this->paid_at,
            'created_at' => $this->created_at,
        ];
    }
}
