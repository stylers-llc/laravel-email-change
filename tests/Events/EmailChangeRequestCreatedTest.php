<?php

namespace Stylers\EmailChange\Tests\Events;

use Illuminate\Support\Facades\Event;
use Stylers\EmailChange\Contracts\EmailChangeRequestInterface;
use Stylers\EmailChange\Events\EmailChangeRequestCreated;
use Stylers\EmailChange\Models\EmailChangeRequest;
use Stylers\EmailChange\Models\User;
use Stylers\EmailChange\Tests\BaseTestCase;

class EmailChangeRequestCreatedTest extends BaseTestCase
{
    /** @test */
    public function it_can_dispatch_event()
    {
        Event::fake();

        $emailChangeableUser = factory(User::class)->create();
        /** @var EmailChangeRequestInterface $emailChangeRequest */
        $emailChangeRequest = factory(EmailChangeRequest::class)->make();
        $emailChangeRequest->emailChangeable()->associate($emailChangeableUser)->save();

        Event::assertDispatched(
            EmailChangeRequestCreated::class,
            function (EmailChangeRequestCreated $e) use ($emailChangeRequest) {
                return $e->getEmailChangeRequest()->id === $emailChangeRequest->id;
            }
        );
    }
}
