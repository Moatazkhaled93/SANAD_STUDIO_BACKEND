<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Pages",
 *     description="API Endpoints for Page Content Management"
 * )
 */
class PageController extends Controller
{
    private PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @OA\Get(
     *     path="/api/pages/{section}",
     *     summary="Get page content for specific section",
     *     tags={"Pages"},
     *     @OA\Parameter(
     *         name="section",
     *         in="path",
     *         description="Page section name (hero, corporate_innovation, how_we_work, partner_with_us)",
     *         required=true,
     *         @OA\Schema(type="string", enum={"hero", "corporate_innovation", "how_we_work", "partner_with_us"})
     *     ),
     *     @OA\Parameter(
     *         name="lang",
     *         in="query",
     *         description="Language code (en or ar)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"en", "ar"}, default="en")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Page content retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="section", type="string"),
     *             @OA\Property(property="language", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page section not found"
     *     )
     * )
     */
    public function show(string $section, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
        $data = $this->pageService->getPageContent($section, $language);

        return response()->json([
            'section' => $section,
            'language' => $language,
            'data' => $data
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/pages/{section}/both-languages",
     *     summary="Get page content for both languages",
     *     tags={"Pages"},
     *     @OA\Parameter(
     *         name="section",
     *         in="path",
     *         description="Page section name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Page content for both languages retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="section", type="string"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="en", type="object"),
     *                 @OA\Property(property="ar", type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function showBothLanguages(string $section): JsonResponse
    {
        $data = $this->pageService->getPageContentBothLanguages($section);

        return response()->json([
            'section' => $section,
            'data' => $data
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/pages/{section}",
     *     summary="Update page content for specific section and language",
     *     tags={"Pages"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="section",
     *         in="path",
     *         description="Page section name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"language", "data"},
     *             @OA\Property(property="language", type="string", enum={"en", "ar"}, example="en"),
     *             @OA\Property(property="data", type="object", example={
     *                 "title": "Hero Section Title",
     *                 "description": "Hero section description"
     *             })
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Page content updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="section", type="string"),
     *             @OA\Property(property="language", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function update(string $section, Request $request): JsonResponse
    {
        $request->validate([
            'language' => 'required|in:en,ar',
            'data' => 'required|array'
        ]);

        $language = $request->input('language');
        $data = $request->input('data');

        $updatedData = $this->pageService->updatePageContent($section, $language, $data);

        return response()->json([
            'message' => 'Page content updated successfully',
            'section' => $section,
            'language' => $language,
            'data' => $updatedData
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/pages",
     *     summary="Get all active pages",
     *     tags={"Pages"},
     *     @OA\Response(
     *         response=200,
     *         description="All active pages retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="pages", type="object")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $pages = $this->pageService->getAllActivePages();

        return response()->json([
            'pages' => $pages
        ]);
    }
}
