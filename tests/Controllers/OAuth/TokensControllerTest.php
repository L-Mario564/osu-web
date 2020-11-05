<?php

// Copyright (c) ppy Pty Ltd <contact@ppy.sh>. Licensed under the GNU Affero General Public License v3.0.
// See the LICENCE file in the repository root for full licence text.

namespace Tests\Controllers\OAuth;

use App\Models\OAuth\Token;
use Laravel\Passport\RefreshToken;
use Tests\TestCase;

class TokensControllerTest extends TestCase
{
    public function testDestroyCurrent()
    {
        $refreshToken = factory(RefreshToken::class)->create();
        $token = $refreshToken->accessToken;

        $this
            ->actingWithToken($token)
            ->json('DELETE', route('api.oauth.tokens.current'))
            ->assertSuccessful();

        $this->assertTrue($token->fresh()->revoked);
        $this->assertTrue($refreshToken->fresh()->revoked);
    }

    public function testDestroyCurrentClientGrant()
    {
        $token = factory(Token::class)->create(['user_id' => null]);

        $this->actAsUserWithToken($token);

        $this
            ->actingWithToken($token)
            ->json('DELETE', route('api.oauth.tokens.current'))
            ->assertSuccessful();

        $this->assertTrue($token->fresh()->revoked);
    }
}
