<?php

it('loads the index page', function () {
    $this
        ->visit('/')
        ->assertSee('Elevkår');
});
