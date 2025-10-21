<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MeasurementRecorded extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $measurementId,
        public int $childId,
        public string $childName,
        public string $measuredAt,
        public ?string $nutritionStatus = null,
    ) {
        //
    }

    public function via(object $notifiable): array
    {
        // DB notifications only (guardrails)
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'measurement_recorded',
            'measurement_id' => $this->measurementId,
            'child_id' => $this->childId,
            'child_name' => $this->childName,
            'measured_at' => $this->measuredAt,
            'nutrition_status' => $this->nutritionStatus,
        ];
    }
}
