<?php

namespace App\Http\Controllers\Api;

use App\Http\StatusCode\HTTPStatusCode;
use App\Models\InterfaceLanguage;
use App\Models\PostType;
use App\Models\Tag;
use App\Service\API\PostAPIService;
use Illuminate\Http\Request;
use App\Http\Requests\PostRatingRequest;
use App\Models\Post;
use App\Http\Controllers\Controller;

/**
 *  @group Post requests rating,types
 *
 *
 * */


class PostController extends Controller
{

    /**
     *  Like post
     *
     * @bodyParam post_id int required
     * @bodyParam type string required Example: like,dislike
     *
     * @param PostRatingRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     */

    public function rating(PostRatingRequest $request)
    {
        $user = $request->user();
        $post = Post::findOrFail($request['post_id']);
        $type = $request['type'];

        $rating = $post->rating()->where('user_id',$user->id)->first();
        if(!$rating) {
            $post->rating()->create([
                'user_id' => $user->id,
                'type' => $type
            ]);
        } else {

            if($rating->type == $type) {
                $rating->delete();
            } else {
                $rating->update([
                    'type' => $type
                ]);
            }

        }

        $likes_count = $post->likes()->count();
        $dislikes_count = $post->dislikes()->count();

        $post->updateRating($likes_count,$dislikes_count);

        $json['data'] = [
            'likes_count' => $likes_count,
            'dislikes_count' => $dislikes_count,
            'rating' => $likes_count - $dislikes_count,
            'you_liked' => (bool) $post->likes()->where('user_id',$user->id)->count(),
            'you_disliked' => (bool) $post->dislikes()->where('user_id',$user->id)->count()
        ];

        return response()->json($json,200);

    }

    /**
     *  tags autocomplete
     *
     * @queryParam term string optional
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */

    public function tag_autocomplete(Request $request)
    {
        $term = $request['term'];

        $tags = Tag::where('name','LIKE','%'.$term.'%')
                    ->limit(5)
                    ->select('id','name')
                    ->get();

        $json['data'] = $tags;

        return response()->json($json,200);
    }


    /**
     *  get post types
     *
     * @queryParam lang string optional Example: ru
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */

    public function getPostTypes(Request $request)
    {
        $lang = InterfaceLanguage::whereCode($request['lang'])->first() ?: InterfaceLanguage::whereCode('ru')->first();

        $post_types = PostType::whereNull('parent_id')
            ->whereNotIn('name',['news'])
            ->select('id', 'name', 'display_name')
            ->get();

        foreach ($post_types as $type) {
            $type->display_name = $type->getTranslation($lang->id,'display_name');
            $type->sub_posts = PostType::where('parent_id',$type->id)
                ->select('id','name','display_name')
                ->get();
            foreach ($type->sub_posts as $sub_type) {
                $sub_type->display_name = $sub_type->getTranslation($lang->id,'display_name');
            }
        }

        return response()->json($post_types,200);

    }

    /**
     *
     *  Find posts full data by name
     *
     * @queryParam page int Default: 1
     * @queryParam perPage int Default: 12
     * @queryParam sort_order string Default: desc | desc,asc
     * @queryParam post_name string Default: ''
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function getPostsByName(Request $request)
    {
        $postService = new PostAPIService();
        $data = $postService->getPostsData($request);

        return response()->json(['data' => $data], HTTPStatusCode::OK);
    }

}