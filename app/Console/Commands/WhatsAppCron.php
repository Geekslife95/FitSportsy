<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderChild;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class WhatsAppCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $date = Carbon::tomorrow();
        // $date = $date->format('m/d');
        $orders = Order::where('ticket_date',$date)->get();  
        foreach ($orders as $order) {
            $ticketDate = date("d M Y",strtotime($order->ticket_date));
            $ticketSlot = $order->ticket_slot;

            $event = Event::Where('id',$order->event_id)->first();
            $eventName = $event->name;
            $location = $event->address;

            $order_child = OrderChild::Where('order_id',$order->id)->first();
            $details = json_decode($order_child->prasada_address);
            $number = $details->prasada_mobile;
            $name = $details->prasada_name;
            $data = [
                "apiKey"=> "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NWIwNWFlZTg5ZTI5NTIwZmE4NjVkYyIsIm5hbWUiOiJCb29rbXlQdWphU2V2YSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGU1OWM1ZjNkYmZlYzAxNmI0OTM3ZmMiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMDQ2NDA0Nn0.44ZUFuJfyla1fzjVneX699hHXHXFh4j0c8YgyHIczYk",
                "campaignName"=> "Event Ticket Booked",
                "destination"=> "+91".$number,
                "userName"=>  $name,
                "source"=> "Website Lead",
                "media"=>[
                "url"=> "https://bookmypujaseva.com/images/upload/64e5ea47be10f.png",
                    "filename"=> "logo"
                ],
                "templateParams"=> [
                    $name,
                    $eventName,
                    $ticketDate,
                    $ticketSlot,
                    $location
                ]
            ];
            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://backend.aisensy.com/campaign/t1/api/v2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Accept: */*",
                "Content-Type: application/json",
            ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            echo $response;
            }


        }
        return 1;
    }
}
