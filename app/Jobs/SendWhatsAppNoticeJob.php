<?php

namespace App\Jobs;

use App\Models\ComputerTrainingNotice;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendWhatsAppNoticeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notice;
    public $phoneNumbers;

    /**
     * Create a new job instance.
     */
    public function __construct(ComputerTrainingNotice $notice, array $phoneNumbers)
    {
        $this->notice = $notice;
        $this->phoneNumbers = array_filter(array_unique($phoneNumbers));
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsAppService): void
    {
        if (empty($this->phoneNumbers)) {
            return;
        }

        $message = "*Notice:* {$this->notice->title}\n\n{$this->notice->body}";
        
        $imageUrl = null;
        if ($this->notice->image_path) {
            // Generate a full URL to the image so the API can fetch it
            $imageUrl = asset(Storage::url($this->notice->image_path));
        }

        foreach ($this->phoneNumbers as $phone) {
            $whatsAppService->sendMessage($phone, $message, $imageUrl);
        }
    }
}
