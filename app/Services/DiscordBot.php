<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class DiscordBot
{
    private $endpoint = 'https://discord.com/api/v6';
    private $botToken;
    private $serverId;
    private $client;

    public function __construct()
    {
        $this->botToken = env('DISCORD_BOT_TOKEN');
        $this->serverId = env('DISCORD_SERVER_ID');
        $this->client = new Client([
            'headers' => [
                'Authorization' => "Bot {$this->botToken}"
            ]
        ]);
    }

    public function getMessage($channelId, $messageId)
    {
        try
        {
            $request = $this->client->request('GET', "{$this->endpoint}/channels/{$channelId}/messages/{$messageId}");
            return json_decode($request->getBody());
        }
        catch(Exception $e)
        {
            return null;
        }
    }

    public function sendMessage($webHook, $message) 
    {
        try
        {
            $request = $this->client->request('POST', $webHook, [
                'json' => $message
            ]);
            return json_decode($request->getBody());
        }
        catch(Exception $e)
        {
            return $e;
        }
    }

    public function deleteMessage($channel, $id) 
    {

    }

    public function reactionMessage($channelId, $messageId, $emoji)
    {
        try
        {
            $request = $this->client->request('PUT', "{$this->endpoint}/channels/{$channelId}/messages/{$messageId}/reactions/{$emoji}/@me");
            return json_decode($request->getBody());
        }
        catch(Exception $e)
        {
            return $e;
        }
    }
}