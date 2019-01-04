<?php

namespace App\Console\Commands;

use Faker\Provider\DateTime;
use Illuminate\Console\Command;
use App\Contenir;
use App\TypeProduit;
use App\Produit;
use App\Reservation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired:reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will delete expired reservations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reservations = Reservation::all();

        foreach ($reservations as $reservation) {
            $numProduit = Contenir::getNumeroProduit($reservation->numReservation);
            $nomTypeProduit = Produit::getTypeProduit($numProduit);
            $timeLeft = TypeProduit::getReservationTime($nomTypeProduit);

            $dateNow = Carbon::now();
            $dateRes = Carbon::parse($reservation->dateReservation);
            $dateRes->addHours($timeLeft);

            // Check if need to delete an expired reservation
            if ($dateNow > $dateRes) {
                // delete relationship with product
                $contenirRow = Contenir::getContenirWithReservationNumber($reservation->numReservation);
                $contenirRow->delete();

                // delete reservation
                $reservation->delete();
                //return $reservation->numReservation;
            }
        }
    }
}
