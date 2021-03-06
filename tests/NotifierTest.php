<?php

declare(strict_types=1);

namespace Notifier\Tests;

use Notifier\Channel\Channels;
use Notifier\Channel\Email\EmailChannel;
use Notifier\Exception\ChannelNotFound;
use Notifier\Channel\Sms\SmsChannel;
use Notifier\Recipient\Recipients;
use Notifier\Tests\TestAsset\Channel\FakeMailer;
use Notifier\Tests\TestAsset\Channel\FakeTexter;
use Notifier\Tests\TestAsset\Model\Todo;
use Notifier\Tests\TestAsset\Model\TodoExpiredNotification;
use PHPUnit\Framework\TestCase;
use Notifier\Notifier;
use Notifier\Tests\TestAsset\Model\User;

class NotifierTest extends TestCase
{
    /** @var Notifier */
    protected $notifier;

    /** @var FakeMailer */
    protected $mailer;

    /** @var FakeTexter */
    protected $texter;

    protected function setUp(): void
    {
        $this->mailer = new FakeMailer();
        $this->texter = new FakeTexter();
        $this->notifier = new Notifier(new Channels(
            new EmailChannel($this->mailer),
            new SmsChannel($this->texter)
        ));
    }

    /**
     * @test
     */
    public function it_sends_notification_via_channels(): void
    {
        $notification = new TodoExpiredNotification(new Todo('Test'));
        $recipients = new Recipients(
            new User('John Doe', [
                EmailChannel::NAME => 'john@example.com',
                SmsChannel::NAME => '+123456789',
            ])
        );

        $this->notifier->send($notification, $recipients);

        $this->assertCount(1, $this->mailer->getMessages());
        $this->assertCount(1, $this->texter->getMessages());
    }

    /**
     * @test
     */
    public function it_sends_notification_via_specific_channel(): void
    {
        $notification = new TodoExpiredNotification(new Todo('Test'));
        $recipients = new Recipients(
            new User('John Doe', [
                EmailChannel::NAME => 'john@example.com',
                SmsChannel::NAME => '+123456789',
            ])
        );

        $this->notifier->sendVia(SmsChannel::NAME, $notification, $recipients);

        $this->assertCount(1, $this->texter->getMessages());
    }

    /**
     * @test
     */
    public function it_raises_exception_if_specific_channel_was_not_found(): void
    {
        $notification = new TodoExpiredNotification(new Todo('Test'));
        $recipients = new Recipients(
            new User('John Doe', [
                EmailChannel::NAME => 'john@example.com',
                SmsChannel::NAME => '+123456789',
            ])
        );

        try {
            $this->notifier->sendVia('slack', $notification, $recipients);

            $this->fail('Exception should have been raised');
        } catch (ChannelNotFound $exception) {
            $this->assertSame("Channel 'slack' was not found", $exception->getMessage());
        }
    }
}
