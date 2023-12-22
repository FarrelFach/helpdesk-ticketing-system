<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HistoryObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        $this->logHistory($ticket, 'created');
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        $changed = $ticket->getChanges();
        foreach ($changed as $field => $newValue) {
            $oldValue = $ticket->getOriginal($field);
            if ($oldValue !== $newValue) {
                $this->logHistory($ticket, 'updated', $field, $oldValue, $newValue);
            }
        }
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        $this->logHistory($ticket, 'deleted');
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }

    protected function logHistory(Ticket $ticket, $action, $field = null, $oldValue = null, $newValue = null)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        History::create([
            'action' => $action,
            'user_id' => Auth::user()->id, // Assuming you're using authentication
            'model' => get_class($ticket),
            'model_id' => $ticket->id,
            'field' => $field,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'created_at' => $today,
            'updated_at' => $today,
        ]);
    }
}
