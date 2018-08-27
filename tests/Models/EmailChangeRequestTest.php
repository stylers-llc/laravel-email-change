<?php

namespace Stylers\EmailChange\Tests\Models;

use Stylers\EmailChange\Models\EmailChangeRequest;
use Stylers\EmailChange\Models\User;
use Stylers\EmailChange\Tests\BaseTestCase;

class EmailChangeRequestTest extends BaseTestCase
{
    /** @test */
    public function it_can_create_with_changeable()
    {
        /** @var User $user */
        $user = factory(User::class)->create(['email' => 'test@mail.com']);
        /** @var EmailChangeRequest $emailChangeRequest */
        $emailChangeRequest = factory(EmailChangeRequest::class)->make(['email' => 'test@new-mail.com']);
        $emailChangeRequest->emailChangeable()->associate($user)->save();

        /** @var User $changeableUser */
        $changeableUser = $emailChangeRequest->emailChangeable()->first();
        $this->assertEquals($user->id, $changeableUser->id);
        $this->assertNotEquals($user->getAttribute('email'), $emailChangeRequest->getAttribute('email'));
    }

    /** @test */
    public function it_can_create_email_change_request()
    {
        $userEmail = 'curr-mail@mail.com';
        $expectedNewEmail = 'new-mail@mail.com';
        /** @var User $emailChangeable */
        $emailChangeable = factory(User::class)->create(['email' => $userEmail]);
        $changeRequest = $emailChangeable->createEmailChangeRequest($expectedNewEmail);

        $this->assertInstanceOf(EmailChangeRequest::class, $changeRequest);
        $this->assertNotEquals($userEmail, $changeRequest->email);
    }

    /** @test */
    public function it_can_persist_change_request()
    {
        $userEmail = 'curr-mail@mail.com';
        $expectedNewEmail = 'new-mail@mail.com';
        /** @var User $emailChangeable */
        $emailChangeable = factory(User::class)->create(['email' => $userEmail]);
        /** @var EmailChangeRequest $changeRequest */
        $changeRequest = $emailChangeable->createEmailChangeRequest($expectedNewEmail);
        $this->assertNotEquals($emailChangeable->email, $changeRequest->email);
        $changeRequest->persistChangeableEmail();
        $emailChangeable->refresh();
        $this->assertEquals($emailChangeable->email, $changeRequest->email);
    }
}
