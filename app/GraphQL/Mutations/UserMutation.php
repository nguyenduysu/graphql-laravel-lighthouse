<?php

namespace App\GraphQL\Mutations;

use App\Comment;
use App\Post;
use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UserMutation
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

    public function delete($rootValue, array $args)
    {
        $user = User::find($args['id']);
        $posts = new Post();
        $comments = new Comment();

        $posts = Post::where('user_id',$args['id']);
        $comments = Comment::where('user_id', $args['id']);

        if(!$user) {
            throw new \Exception("Resource not found");
        }
        if(isset($posts)) {
            $posts->delete();
        }
        if(isset($comments)) {
            $comments->delete();
        }

        $user->delete();
        return "Success";
    }

    public function update($rootValue, array $args, GraphQLContext $context)
    {
        $user = User::where('email', $args['email'])->first();
        if($user->id != $context->user()->id){
            throw new \Exception("You just only change password of your account!");
        }
        if(!$user) {
            throw new \Exception("Resource not found");
        }
        if($args['password'] != $args['passwordConfirm']) {
            throw new \Exception("Confirm Password Fail");
        }
        $user->password = bcrypt($args['password']);
        $user->save();
        return "Success";
    }

}
