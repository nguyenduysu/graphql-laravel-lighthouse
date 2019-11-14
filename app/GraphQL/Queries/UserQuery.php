<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UserQuery
{
    public function login($rootValue, array $args) {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password']
        ];

        $token = auth()->attempt($credentials);
        if(!$token) {
            throw new \Exception("Unauthorized");
        }

        $authPayload = new \stdClass();
        $authPayload->token = $token;
        $authPayload->type = "Bearer";
        $authPayload->expired = auth()->factory()->getTTL()*60;

        return $authPayload;
    }
}
