<?php


use App\Http\Controllers\UserController;

test('it literally acts as a basic unit test', function () {
    $this->assertTrue(true);
});

test('the user controller installation directory suffix removal works', function ($installDir, $expected) {
    $transformedInstallDir = UserController::transformInstallDir($installDir);
    expect($transformedInstallDir)->toBe($expected);
})->with([
    ['/Users/alex/Desktop/Test', '/Users/alex/Desktop/Test'],
    ['/Users/alex/Desktop/Test/', '/Users/alex/Desktop/Test'],
    ['/Users/alex/Desktop/Test/@Mods_AAF', '/Users/alex/Desktop/Test'],
    ['/Users/alex/Desktop/Test/@Mods_AAF/', '/Users/alex/Desktop/Test'],
    ['C:\Users\alex\Arma 3\Test', 'C:\Users\alex\Arma 3\Test'],
    ['C:\Users\alex\Arma 3\Test\\', 'C:\Users\alex\Arma 3\Test'],
    ['C:\Users\alex\Arma 3\Test\\@Mods_AAF', 'C:\Users\alex\Arma 3\Test'],
    ['C:\Users\alex\Arma 3\Test\\@Mods_AAF\\', 'C:\Users\alex\Arma 3\Test'],
]);
