<x-mail::message>
# {{$customerName}}, your appointment is confirmed!

Title: {{$appointment->title}}<br>
Description: {{$appointment->description}}<br>
From: {{$timeHelper->fromStringToUserObject($appointment->start)->format('D M d g A')}} - {{$timeHelper->fromStringToUserObject($appointment->end)->format('g A e')}}<br>
Type: {{$appointment->type}}<br>
With: {{$repName}}

If you need to reschedule, please email {{$repEmail}} or email mail@example.com.

See you then!
-Marine Logistics
</x-mail::message>
