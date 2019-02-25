<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbuseRequest;
use App\Http\Requests\PostFavoriteRequest;
use App\Models\Abuse;
use App\Models\Abuses;
use App\Models\AbuseType;
use App\Models\CommentRating;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\UserFavoritePost;
use App\Models\User;


/**
 * @group Abuses
 *
 * APIs for user abuses
 */
class AbuseController extends Controller
{
    /**
     * Add post abuse
     * @api /api/v1/abuse/post/{post_id} POST
     *
     * @bodyParam description string (10000) The description of abuse
     *
     * @param int $post_id The id of post
     * @param AbuseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function addPostAbuse(AbuseRequest $request, $post_id)
    {
        $user = User::getAuthApiUser();
        $data = $request->all();
        $data["doc_id"] = $post_id;
        $data["creator_user_id"] = $user->id;
        $data["abuse_type_id"] = AbuseType::POST_TYPE;
        if (!is_null($response = $this->save($data))) {
            $json['error'] = $response;
        } else {
            $json['data'] = 'success';
        }

    }

    /**
     * Add comment abuse
     * @api /api/v1/abuse/comment/{comment_id} POST
     *
     * @bodyParam description string (10000) The description of abuse
     *
     * @param  $comment_id int The id of comment
     * @param AbuseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCommentAbuse(AbuseRequest $request, $comment_id)
    {
        $user = User::getAuthApiUser();
        $data = $request->all();
        $data["doc_id"] = $comment_id;
        $data["creator_user_id"] = $user->id;
        $data["abuse_type_id"] = AbuseType::COMMENT_TYPE;
        if (!is_null($response = $this->save($data))) {
            $json['error'] = $response;
        } else {
            $json['data'] = 'success';
        }

        return response()->json($json);
    }


    /**
     * Save abuse data
     *
     * @param  $data array
     * @return mixed
     */
    protected function save($data)
    {
        if ($data["abuse_type_id"] == AbuseType::POST_TYPE) {
            $post = Post::find($data["doc_id"]);
            if (is_null($post)) {
                return "Публикация не найдена";
            } else {
                $data["respondent_user_id"] = $post->user_id;

            }
        }
        if ($data["abuse_type_id"] == AbuseType::COMMENT_TYPE) {
            $comment = PostComment::find($data["doc_id"]);
            if (is_null($comment)) {
                return "Комментарий не найден";
            } else {
                $data["respondent_user_id"] = $comment->user_id;

            }
        }

        if (!$result = Abuse::create($data)) {
            return "Ошибка создания жалобы";
        }

        return null;
    }
}