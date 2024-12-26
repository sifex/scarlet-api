<?php

use App\User;

$existing_database_state = '--path database/migrations/2014_10_12_000000_create_users_table.php --path database/migrations/2014_10_12_100000_create_password_resets_table.php --path database/migrations/2016_11_02_070159_create_tokens_table.php --path database/migrations/2017_06_08_073337_CreateScarClansTable.php --path database/migrations/2017_06_09_063459_AddRemarkColumn.php --path database/migrations/2017_06_12_062658_AddedPlayerIDColumn.php --path database/migrations/2017_07_12_062658_RenamedPlayerIDColumn.php';

it('tests that everything will work after the neo migration', function () use ($existing_database_state) {

    /**
     * Call everything up to the existing migrations
     */
    Artisan::call('migrate '.$existing_database_state);

    $db_path = __DIR__.'/db_2022_06_26.sql';

    if (file_exists($db_path)) {
        DB::unprepared(file_get_contents($db_path));
        print_r("Imported old DB\r\n");
    }

    Artisan::call('migrate');

    expect(User::count())->toBeGreaterThan(50)
        ->and(User::whereNotNull('playerID')->count())->toBeGreaterThan(20);
});
