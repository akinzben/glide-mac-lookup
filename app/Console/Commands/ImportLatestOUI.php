<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ImportLatestOUI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oui:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the latest version of the IEEE OUI data into
    a database.';

   
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        

        //fetch OUI data online
        $oui_path = file_get_contents("http://standards-oui.ieee.org/oui/oui.csv");

        //separate each record
        $lines = explode("\n", $oui_path);

        //Delete all current OUI data after fetching Latest
        if(count($lines)>0){
            DB::table('o_u_i_records')->truncate();
        }else{
            $this->error('No OUI Data Found!');
        }


        $i = 0;

        $count_oui_data=count($lines);

        //Get time Started
        $start_time = Carbon::now();

        
        $this->comment('Adding '.$count_oui_data.' OUI records...');
        $this->question('Time Started - '.$start_time->toDateTimeString());

        $this->output->progressStart($count_oui_data);

        //Loop through each data
        foreach($lines as $line) {


            $values = str_getcsv($line);

            //Confirm data values is set, to avoid "Undefined offset error"
            if(isset($values[0])){
                $registry = $values[0];
            }else{
                $registry = "N/A";
            } 

            if(isset($values[1])){
                $assignment = $values[1];
            }else{
                $assignment = "N/A";
            }

            if(isset($values[2])){
                $organization_name = $values[2];
            }else{
                $organization_name = "N/A";
            }

            if(isset($values[3])){
                $organization_address = $values[3];
            }else{
                $organization_address = "N/A";
            }
            
            
            $data = array(
                'Registry'=>$registry,
                'Assignment'=>$assignment,
                'Organization_Name'=>$organization_name,
                'Organization_Address'=>$organization_address
            );

            //Insert OUI Data to Database
            if($i!=0){
                $query = DB::table('o_u_i_records')->insert($data);

                if($query){
                    //Display success message for each record  in console
                    //$this->info('Added '.$i. ' - '.$assignment.', ' .$organization_name);

                    //move progress bar
                    $this->output->progressAdvance();
                }else{
                    $this->error('Unable to Add '.$i. ' - '.$assignment.', ' .$organization_name.'');
                }
            }


            $i++;
        }

        $this->output->progressFinish();

        //Get time Ended
        $end_time = Carbon::now();

        $this->question('Time Ended - '.$end_time->toDateTimeString());

        $this->info('OUI update successful.');
        

    }
}
