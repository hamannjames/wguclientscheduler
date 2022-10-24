<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Appointment;
use Services\Helpers\TimeHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentConfirmationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_appointment_confirmation_content()
    {   
        $customer = Customer::factory()->create();
        $rep = User::factory()->create();

        $appointment = Appointment::factory()
            ->for($rep)
            ->for($customer)
            ->create();

        $th = TimeHelper::get();

        $start = $th->fromStringToUserObject($appointment->start)->format('D M d g');
        $end = $th->fromStringToUserObject($appointment->end)->format('g A e');
            
        $mailable = new AppointmentConfirmation($appointment, $customer->first_name, $rep->name, $rep->email);
        $mailable->assertFrom('marinelogistics@mg.jameshamann.net');
        $mailable->assertDontSeeInHtml($customer->first_level_division);
        $mailable->assertSeeInHtml($customer->first_name);
        $mailable->assertSeeInHtml($appointment->title);
        $mailable->assertSeeInHtml($appointment->description);
        $mailable->assertSeeInHtml($start);
        $mailable->assertSeeInHtml($end);
        $mailable->assertSeeInHtml($rep->email);
        $mailable->assertSeeInHtml($rep->name);
        $mailable->assertSeeInOrderInHtml([
            $customer->first_name,
            $appointment->title,
            $appointment->description,
            $start,
            $end,
            $rep->name,
            $rep->email
        ]);
    }

    public function test_appointment_confirmation_send()
    {   
        $customer = Customer::factory()->create();
        $rep = User::factory()->create();

        $appointment = Appointment::factory()
            ->for($rep)
            ->for($customer)
            ->create();

        $mailable = new AppointmentConfirmation($appointment, $customer->first_name, $rep->name, $rep->email);

        Mail::fake();
        Mail::assertNothingSent();
        Mail::to($customer)->send($mailable);
        Mail::assertSent(AppointmentConfirmation::class, 1);
        $mailable->assertTo($customer->email);
    }
}
