<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PartnerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Partners",
 *     description="API Endpoints for Partner Management"
 * )
 */
class PartnerController extends Controller
{
    private PartnerService $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    /**
     * @OA\Get(
     *     path="/api/partners",
     *     summary="Get all partners",
     *     tags={"Partners"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page",
     *         required=false,
     *         @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"pending", "contacted", "approved", "rejected"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Partners retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status');

        if ($status) {
            $partners = $this->partnerService->getPartnersByStatus($status);
            return response()->json(['data' => $partners]);
        }

        $partners = $this->partnerService->getAllPartners($perPage);
        return response()->json($partners);
    }

    /**
     * @OA\Post(
     *     path="/api/partners",
     *     summary="Create a new partner inquiry",
     *     tags={"Partners"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"full_name", "company_email", "organization", "phone_number", "message"},
     *             @OA\Property(property="full_name", type="string", example="John Doe"),
     *             @OA\Property(property="company_email", type="string", format="email", example="john@company.com"),
     *             @OA\Property(property="organization", type="string", example="Tech Corp"),
     *             @OA\Property(property="phone_number", type="string", example="+1234567890"),
     *             @OA\Property(property="message", type="string", example="We are interested in partnering with you.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Partner inquiry created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'organization' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'message' => 'required|string|max:1000'
        ]);

        $partner = $this->partnerService->createPartner($request->all());

        return response()->json([
            'message' => 'Partner inquiry submitted successfully',
            'data' => $partner
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/partners/{id}",
     *     summary="Get partner by ID",
     *     tags={"Partners"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Partner ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Partner retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $partner = $this->partnerService->getPartnerById($id);

        return response()->json([
            'data' => $partner
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/partners/{id}/status",
     *     summary="Update partner status",
     *     tags={"Partners"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Partner ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"pending", "contacted", "approved", "rejected"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Partner status updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function updateStatus(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,approved,rejected'
        ]);

        $partner = $this->partnerService->updatePartnerStatus($id, $request->status);

        return response()->json([
            'message' => 'Partner status updated successfully',
            'data' => $partner
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/partners/{id}",
     *     summary="Delete partner",
     *     tags={"Partners"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Partner ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Partner deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->partnerService->deletePartner($id);

        return response()->json([
            'message' => 'Partner deleted successfully'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/partners/statistics",
     *     summary="Get partner statistics",
     *     tags={"Partners"},
     *     security={{"passport":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Partner statistics retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="statistics", type="object")
     *         )
     *     )
     * )
     */
    public function statistics(): JsonResponse
    {
        $stats = $this->partnerService->getPartnerStatistics();

        return response()->json([
            'statistics' => $stats
        ]);
    }
}
