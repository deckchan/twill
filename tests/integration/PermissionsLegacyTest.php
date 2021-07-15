<?php

namespace A17\Twill\Tests\Integration;

use A17\Twill\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionsLegacyTest extends PermissionsTestBase
{
    public function configTwill($app)
    {
        parent::configTwill($app);

        $app['config']->set('twill.enabled.permissions-management', false);
        $app['config']->set('twill.enabled.settings', true);
    }

    public function createUser($role)
    {
        $user = User::make([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'role' => $role,
            'published' => true,
        ]);
        $user->password = Hash::make($user->email);
        $user->save();

        return $user;
    }

    public function testViewOnlyPermissions()
    {
        $admin = $this->createUser('ADMIN');

        $this->loginUser($guest = $this->createUser('VIEWONLY'));

        // User is logged in
        $this->httpRequestAssert('/twill');
        $this->assertSee($guest->name);

        // User can access the Media Library
        $this->httpRequestAssert('/twill/media-library/medias?page=1&type=image');

        // User can't upload medias
        $this->httpRequestAssert('/twill/media-library/medias', 'POST', [], 403);

        // User can't access settings
        $this->httpRequestAssert('/twill/settings/seo', 'GET', [], 403);

        // User can't access users list
        $this->httpRequestAssert("/twill/users", 'GET', [], 403);

        // User can't access other profiles
        $this->httpRequestAssert("/twill/users/{$admin->id}/edit", 'GET', [], 403);

        // User can access own profile
        $this->httpRequestAssert("/twill/users/{$guest->id}/edit");
    }
}