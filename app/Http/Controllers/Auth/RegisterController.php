<?php


namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RegisterController
{
    /**
     * Display the registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('register');
    }

    /**
     * Handle submissions of the registration form.
     * Validate the form and sends user PII to the RabbitMQ.
     *
     * @param Illuminate\Http\Request $request
     * @return nothing really. Creates a page making fun of the user.
     */
    public function postRegister(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:50',
            'birthdate' => 'required|date|before:now',
            'email' => 'required|email',
            'mobile' => 'min:11|numeric|nullable',
            'password' => 'required|min:6|max:512',
        ]);

        // TODO: either this $url = parse_url(getenv('CLOUDAMQP_URL')) or const file.
        $url = parse_url('amqp://lcwcwqql:v8uI7vRvPPzfvMoHs0YqBt1-zjVyHlJa@rhino.rmq.cloudamqp.com/lcwcwqql');
        $conn = new AMQPStreamConnection($url['host'], 5672, $url['user'], $url['pass'], $url['user']);
        $ch = $conn->channel();
        $exchange = 'amq.direct';
        // This is clearly a ridiculous hack to get to the existing queue that blink can handle.
        // Also the queue name should be a contant and defined either as env  var or in a const file.
        $queue = 'customer-io-campaign-signup';
        $ch->exchange_declare($exchange, 'direct', true, true, false);
        $ch->queue_bind($queue, $exchange);

        $msg = new AMQPMessage(json_encode($request->post()),
                               array('content_type' => 'text/plain',
                                     'delivery_mode' => 2));
        echo "And just like that. Your PII will 
              be avaialbe for all to see at yz_dscodetest@mailinator.com";
        $ch->basic_publish($msg, $exchange);
        // TODO: can publish fail? if so, either retry or tell user to come again later
        // or persist info in some other way.
        $ch->close();
        $conn->close();
    }

}
