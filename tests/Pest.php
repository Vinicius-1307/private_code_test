<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure below can be used to configure middleware for your tests.
|
*/

uses(Tests\TestCase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| IDE Helper
|--------------------------------------------------------------------------
|
| Ajuda IDEs a entenderem as propriedades dinâmicas do Pest.
| Para melhor suporte no IDE, instale o plugin Pest:
| - PhpStorm: https://plugins.jetbrains.com/plugin/14636-pest
| - VSCode: Instale "Better Pest"
|
*/

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

// expect()->extend('toBeOne', function () {
//     return $this->toBe(1);
// });

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

// function something()
// {
//     // ..
// }
