<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="API Endpoints for Blog Post Management"
 * )
 */
class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     tags={"Posts"},
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
     *         @OA\Schema(type="string", enum={"draft", "published", "archived"})
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search in title and content",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="lang",
     *         in="query",
     *         description="Language for search",
     *         required=false,
     *         @OA\Schema(type="string", enum={"en", "ar"}, default="en")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Posts retrieved successfully",
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
        $search = $request->get('search');
        $language = $request->get('lang', 'en');

        if ($search) {
            $posts = $this->postService->searchPosts($search, $language, $perPage);
        } elseif ($status) {
            $posts = $this->postService->getPostsByStatus($status, $perPage);
        } else {
            $posts = $this->postService->getAllPosts($perPage);
        }

        return response()->json($posts);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/published",
     *     summary="Get published posts",
     *     tags={"Posts"},
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
     *     @OA\Response(
     *         response=200,
     *         description="Published posts retrieved successfully"
     *     )
     * )
     */
    public function published(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $posts = $this->postService->getPublishedPosts($perPage);

        return response()->json($posts);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/featured",
     *     summary="Get featured posts",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of posts to return",
     *         required=false,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Featured posts retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function featured(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 5);
        $posts = $this->postService->getFeaturedPosts($limit);

        return response()->json([
            'data' => $posts
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     security={{"passport":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "content", "author"},
     *             @OA\Property(property="title", type="object", example={"en": "Post Title", "ar": "عنوان المقال"}),
     *             @OA\Property(property="description", type="object", example={"en": "Post description", "ar": "وصف المقال"}),
     *             @OA\Property(property="content", type="object", example={"en": "Post content", "ar": "محتوى المقال"}),
     *             @OA\Property(property="author", type="string", example="John Doe"),
     *             @OA\Property(property="cover_image", type="string", example="path/to/image.jpg"),
     *             @OA\Property(property="is_featured", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", enum={"draft", "published", "archived"}, example="draft")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
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
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'description.ar' => 'required|string',
            'content' => 'required|array',
            'content.en' => 'required|string',
            'content.ar' => 'required|string',
            'author' => 'required|string|max:255',
            'cover_image' => 'nullable|string',
            'is_featured' => 'boolean',
            'status' => 'in:draft,published,archived'
        ]);

        $data = $request->all();
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $post = $this->postService->createPost($data);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => $post
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get post by ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getPostById($id);

        return response()->json([
            'data' => $post
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update post",
     *     tags={"Posts"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="object"),
     *             @OA\Property(property="description", type="object"),
     *             @OA\Property(property="content", type="object"),
     *             @OA\Property(property="author", type="string"),
     *             @OA\Property(property="cover_image", type="string"),
     *             @OA\Property(property="is_featured", type="boolean"),
     *             @OA\Property(property="status", type="string", enum={"draft", "published", "archived"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'sometimes|array',
            'description' => 'sometimes|array',
            'content' => 'sometimes|array',
            'author' => 'sometimes|string|max:255',
            'cover_image' => 'nullable|string',
            'is_featured' => 'boolean',
            'status' => 'in:draft,published,archived'
        ]);

        $data = $request->all();
        if (isset($data['status']) && $data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $post = $this->postService->updatePost($id, $data);

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}/status",
     *     summary="Update post status",
     *     tags={"Posts"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"draft", "published", "archived"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post status updated successfully",
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
            'status' => 'required|in:draft,published,archived'
        ]);

        $post = $this->postService->updatePostStatus($id, $request->status);

        return response()->json([
            'message' => 'Post status updated successfully',
            'data' => $post
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete post",
     *     tags={"Posts"},
     *     security={{"passport":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->postService->deletePost($id);

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/statistics",
     *     summary="Get post statistics",
     *     tags={"Posts"},
     *     security={{"passport":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Post statistics retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="statistics", type="object")
     *         )
     *     )
     * )
     */
    public function statistics(): JsonResponse
    {
        $stats = $this->postService->getPostStatistics();

        return response()->json([
            'statistics' => $stats
        ]);
    }
}
