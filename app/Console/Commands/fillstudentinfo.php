<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Log;

class fillstudentinfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:studentinfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $student_ids = DB::table('consultant_financials')->distinct()->pluck('student_id');

        $students = DB::table('aref_newcrm.students as dt1')
            ->select("school", "id", 'first_name', 'last_name', 'nationality_code', 'phone', 'major', 'egucation_level', 'concours_year')
            ->whereIn('dt1.id', $student_ids)
            ->get();

        foreach ($students as $student) {
            //Log::info("student['school'] ids iare:" . $student->school);

            $exist = DB::table('student_infos')->where('student_id', $student->id)->first();
            if (!$exist) {
                DB::table('student_infos')->insert([
                    [
                        "school_name" => $student->school,
                        "student_id" => $student->id,
                        "first_name" => $student->first_name,
                        "last_name" => $student->last_name,
                        "nationality_code" => $student->nationality_code,
                        "phone" => $student->phone,
                        "major" => $student->major,
                        "education_level" => $student->egucation_level,
                        "concours_year" => $student->concours_year,
                    ]
                ]);
            }
        }

        //Log::info("st ids iare:" . json_encode($query));

        return Command::SUCCESS;
    }
}
