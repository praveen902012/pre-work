<?php
namespace Redlof\Core\RedlofSDK\ServiceProviders;

use Illuminate\Mail\MailServiceProvider;
use Redlof\Core\RedlofSDK\Mail\Transport\RedlofMailTransport;

class RedlofMailServiceProvider extends MailServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    public function registerSwiftMailer()
    {
        if ($this->app['config']['mail.driver'] == 'redlof') {
            $this->registerDBSwiftMailer();
        } else {
            parent::registerSwiftMailer();
        }
    }

    private function registerDBSwiftMailer()
    {
        $this->registerSwiftTransport();

        // Once we have the transporter registered, we will register the actual Swift
        // mailer instance, passing in the transport instances, which allows us to
        // override this transporter instances during app start-up if necessary.
        $this->app->singleton('swift.mailer', function ($app) {

            if ($domain = $app->make('config')->get('mail.domain')) {

                Swift_DependencyContainer::getInstance()
                    ->register('mime.idgenerator.idright')
                    ->asValue($domain);
            }

            return new \Swift_Mailer(new RedlofMailTransport());
        });
    }
}
