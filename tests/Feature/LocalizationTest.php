<?php

test('the homepage is in Swedish', function () {
    $this->app->setLocale('sv');
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('SSIS aktuella evenemang');
});

test('the login page is in Swedish', function () {
    $this->app->setLocale('sv');
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Logga in');
    $response->assertSee('Logga in med Google');
});
