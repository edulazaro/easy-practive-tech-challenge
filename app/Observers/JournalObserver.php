<?php

namespace App\Observers;

use App\Models\Journal;
use App\Helpers\StringHelper;

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
