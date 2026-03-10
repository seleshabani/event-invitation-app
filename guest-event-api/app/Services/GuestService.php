<?php

namespace App\Services;

use App\Jobs\GuestProcessJob;
use App\Mail\EventInvitation;
use App\Mail\EventInvitationMail;
use App\Repositories\EventRepository;
use App\Repositories\GuestRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use OpenSpout\Common\Entity\Cell\FormulaCell;
use OpenSpout\Reader\XLSX\Reader;

use function Illuminate\Log\log;

class GuestService
{
    //

    public function __construct(
        private GuestRepository $repository,
        private EventRepository $eventRepository
    ) {}



    /**
     * Handle the uploaded guest file and dispatch a job for processing.
     * @param int $eventId The ID of the event to which the guests belong.
     * @param \Illuminate\Http\UploadedFile $file The uploaded file containing guest information.
     * @throws \Exception If there is an error during file handling or job dispatching.
     * @return void
     */
    public function uploadGuests($eventId, $file)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        Storage::disk('local')->put('guests/' . $filename, file_get_contents($file));
        GuestProcessJob::dispatch($filename, $eventId);
    }

    /**
     * Process the guest file and store the guest information in the database.
     * @param string $filename The name of the file to be processed.
     * @param int $eventId The ID of the event to which the guests belong.
     * @throws \Exception If there is an error during file processing or database operations.
     * @return void
     */
    public function processGuestFile(string $filename, int $eventId): void
    {
        $filePath = storage_path('app/private/guests/' . $filename);
        $event = $this->eventRepository->getById($eventId);

        if (!file_exists($filePath)) {
            log()->error("Fichier introuvable : {$filePath}");
            return;
        }

        $reader = new Reader();

        try {
            $reader->open($filePath);

            foreach ($reader->getSheetIterator() as $sheet) {
                $isFirstRow = true;

                foreach ($sheet->getRowIterator() as $row) {
                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }

                    $cells = $row->getCells();

                    if (!isset($cells[0], $cells[1])) {
                        continue;
                    }

                    $name = (string) $cells[0]->getValue();

                    // Extraction optimisée de la valeur (Formule vs Brut)
                    $emailCell = $cells[1];
                    $email = ($emailCell instanceof FormulaCell)
                        ? $emailCell->getComputedValue()
                        : $emailCell->getValue();

                    if (!empty($name) && !empty($email)) {
                       $guest = $this->repository->store([
                            'name'     => trim($name),
                            'email'    => trim((string) $email),
                            'event_id' => $eventId
                        ]);
                        
                        $guest->update(['invitation_sent' => true]);
                        Mail::to($email)->send(new EventInvitationMail($event, $guest));
                    }


                }
            }
        } catch (\Exception $e) {
            log()->error("Erreur lors du traitement Excel : " . $e->getMessage());
        } finally {
            $reader->close();
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
