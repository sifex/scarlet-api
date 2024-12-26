<?php

use Tests\DuskTestCase;

/**
 * Feature
 */
uses(Tests\TestCase::class)->in('Feature');

/**
 * Dusk
 */
uses(DuskTestCase::class)->in('Browser');
