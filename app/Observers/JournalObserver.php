<?php

namespace App\Observers;

use App\Helpers\StringHelper;
use App\Models\Journal;

class JournalObserver
{
    /*
    * Handle the Journal "deleting" event.
    */
    public function creating(Journal $journal): void
    {
        $journal->excerpt = StringHelper::getExcerpt($journal->content, 80);
    }
}
