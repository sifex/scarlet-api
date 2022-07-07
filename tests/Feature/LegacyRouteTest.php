<?php


use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it handles old routes correctly', function () {
    expect($this->get('/')->getStatusCode())->not->toEqual(404)
        ->and($this->get('/key/electron/')->getStatusCode())->not->toEqual(404)
        ->and($this->get('/key/')->getStatusCode())->not->toEqual(404)
        ->and($this->get("/auth/electron/"))->not->toEqual(404)
        ->and($this->post("/auth/"))->not->toEqual(404)
        ->and($this->get('/admin/')->getStatusCode())->not->toEqual(404)
        ->and($this->get('/xml/')->getStatusCode())->not->toEqual(404);
});


