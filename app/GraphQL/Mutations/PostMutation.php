<?php

namespace App\GraphQL\Mutations;

use App\Comment;
use App\Post;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class PostMutation
{
    /**
     * Return a value for the field.
     *
     * @param null $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[] $args The arguments that were passed into the field.
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context Arbitrary data that is shared between all fields of a single query.
     * @param \GraphQL\Type\Definition\ResolveInfo $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
    }

    public function create($rootValue, array $args, GraphQLContext $context)
    {
        $post = new Post();
        $post->user_id = $context->user()->id;
        $post->title = $args['title'];
        $post->content = $args['content'];
        $post->save();

        return $post;
    }

    public function update($rootValue, array $args, GraphQLContext $context)
    {
        $post = Post::find($args['id']);
        if(!$post) {
            throw new \Exception("Resource not found");
        }
        if($post->user_id != $context->user()->id) {
            throw new \Exception("You just only edit your post");
        }
        if(isset($args['title'])) {
            $post->title = $args['title'];
        }
        if(isset($args['content'])) {
            $post->content = $args['content'];
        }
        $post->save();
        return $post;
    }

    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        $post = Post::find($args['id']);
        $comments = Comment::where('post_id', $args['id']);

        if(!$post) {
            throw new \Exception("Resource not found");
        }
        if($post->user_id != $context->user()->id) {
            throw new \Exception("You just only delete your post");
        }
        $post->delete();
        $comments->delete();
        return "Success";
    }
}
