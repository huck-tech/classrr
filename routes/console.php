<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('update_classroom', function(){
	$items = \App\Classroom::all();
	foreach ($items as $item) {
		$item->document()->update();
	}
})->describe('Updating Classroom Elasticsearch');


Artisan::command('remove_classroom {id}', function ($id) {
    $c = \App\Classroom::findOrFail($id);
    $this->info('Deleting #'. $id . ' classroom.');
    $this->line('Slug: ' . $c->slug);

    if ($this->confirm('Do you wish to delete this class room?')) {
        $c->delete();
        $this->line('Done.');
    }
})->describe('Removing Classroom By ID syntax: "php artisan remove_classroom CLASSRROM_ID_HERE"');
