<?php

namespace App\Http\Controllers;

use App\Models\Post;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQController extends Controller
{
	public function send($postdata)
	{
		$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();

		$channel->queue_declare('post_data', false, false, false, false);

		$msg = new AMQPMessage($postdata);
		$channel->basic_publish($msg, '', 'post_data');

		echo " [x] Sent : " . $postdata . "\n";

		$channel->close();
		$connection->close();
		return 1;
	}

	public function receive()
	{
		$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();

		$channel->exchange_declare('post_data', 'fanout', false, false, false);

		list($queue_name,,) = $channel->queue_declare("subscriberB", false, false, true, false);

		$channel->queue_bind($queue_name, 'post_data');

		echo " [*] Waiting for messages. To exit press CTRL+C\n";

		$callback = function ($msg) {
			$postdata = json_decode($msg->body);
			echo " [x] Received Data\n";
			$post = new Post;
			$post->user_id =  $postdata->user_id;
			$post->cat_id = $postdata->cat_id;
			$post->title = $postdata->title;
			$post->content = $postdata->content;
			$post->image = $postdata->image_name;
			$post->save();
		};

		$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

		while ($channel->is_open()) {
			$channel->wait();
		}

		$channel->close();
		$connection->close();
	}
}
