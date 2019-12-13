<?php

namespace App\GraphQL\Mutations;

use App\Comment;
use App\Notifications\CommentCreatedNotification;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CommentMutation
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
    }

    public function create($rootValue, array $args, GraphQLContext $context)
    {
        $comment = new Comment();
        $comment->user_id = $context->user()->id;
        $comment->post_id = $args['post_id'];
        $comment->reply = $args['reply'];
        $comment->save();

        $context->user()->notify(new CommentCreatedNotification($comment));

        return $comment;
    }

    public function update($rootValue, array $args, GraphQLContext $context)
    {
        $comment = Comment::find($args['id']);
        if(!$comment) {
            throw new \Exception("Resource not found");
        }
        if($comment->user_id != $context->user()->id) {
            throw new \Exception("You just only edit your comment");
        }
        if(isset($args['reply'])) {
            $comment->reply = $args['reply'];
        }
        $comment->save();
        return $comment;
    }

    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        $comment = Comment::find($args['id']);
        if(!$comment) {
            throw new \Exception("Resource not found");
        }
        if($comment->user_id != $context->user()->id) {
            throw new \Exception("You just only delete your comment");
        }
        $comment->delete();

        return "Success";
    }
}
