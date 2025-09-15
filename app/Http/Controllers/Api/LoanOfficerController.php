<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LoanOfficerService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class LoanOfficerController extends Controller
{
    public function customerdestroy($id, LoanOfficerService $customerlist): JsonResponse
    {
        try {
            $customerlist->deleteCustomer($id);
            return response()->json(null, 204); // 204 - standard for successful DELETE
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'ok'      => false,
                'message' => "Customer #$id not found",
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'      => false,
                'message' => "Failed to delete customer #$id",
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
