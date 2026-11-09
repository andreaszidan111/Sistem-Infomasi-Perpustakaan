<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('authenticated users see a link to the dashboard for their role', function (string $roleName, string $routeName) {
    Role::create([
        'name' => $roleName,
        'guard_name' => 'web',
    ]);

    $user = User::factory()->create();
    $user->assignRole($roleName);

    $response = $this->actingAs($user)->get('/');

    $response->assertOk();
    $response->assertSee('href="'.route($routeName).'"', false);
})->with([
    'admin' => ['admin', 'admin.dashboard'],
    'petugas' => ['petugas', 'petugas.dashboard'],
    'siswa' => ['siswa', 'siswa.dashboard'],
]);
