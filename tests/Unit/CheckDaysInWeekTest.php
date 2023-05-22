<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Rules\CheckDaysPassedOrNot;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class CheckDaysInWeekTest extends TestCase
{
    protected $checkDays;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function setDateTime($year,$month,$day,$hour,$min){
        $now = Carbon::create($year,$month,$day,$hour,$min); // create testing date
        Carbon::setTestNow($now); // set the mock (of course this could be a real mock object)
    }
    public function test_CheckNotSaturday()
    {
        $this->setDateTime(2023,5,22,8,0);
        // $now = Carbon::create(2023,5,22,8,0); // create testing date
        // Carbon::setTestNow($now); // set the mock (of course this could be a real mock object)
        //echo Carbon::now();
        //$this->assertEquals("2023-05-22 12:00:00",$now,"it is the same");

        $days_given=["Saturday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Current";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertFalse($result);
        
    }

    public function test_CheckNotSunday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Sunday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Current";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertFalse($result);
        
    }

    public function test_CheckMonday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Monday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Current";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckTuesday()
    {
        $this->setDateTime(2023,5,22,8,0);
        $days_given=["Tuesday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Current";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckWednesday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Wednesday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Current";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckThursday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Thursday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Current";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckFriday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Friday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Current";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckAllCurrentWeek()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Current";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }

    public function test_CheckAllNextWeek()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Next";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckAllNextSaturday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Saturday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Next";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckAllNextSunday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Sunday"];//,"Monday","Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Next";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckAllNextMonday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Monday"];//,"Tuesday","Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Next";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckAllNextTuesday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Tuesday"];//,"Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Next";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckAllNextWednesday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Wednesday"];//,"Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Next";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckAllNextThursday()
    {
        $this->setDateTime(2023,5,22,8,0);

        $days_given=["Thursday"];//,"Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Next";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
    public function test_CheckAllNextFriday()
    {
        $this->setDateTime(2023,5,22,9,0);

        $days_given=["Friday"];//,"Wednesday","Thursday","Friday"];
        $start_hour="08:30";
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');         
        
        $this->checkDays=new CheckDaysPassedOrNot($days_given, $start_hour);    
        $week_given="Next";
        $result=$this->checkDays->CheckDaysInWeek($week_given);
        $this->assertTrue($result);
        
    }
}
