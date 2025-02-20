<?php
namespace classes\advice;

use classes\api\exception\server\InternalServerErrorException;
use Monolog\Logger;
use OpenAI;

class OpenAIAdviceProvider implements AdviceProviderInterface
{
    private $client;
    private $logger;

    function __construct(Logger $logger)
    {
        if ($GLOBALS['config']['advice']['enabled'] !== true) {
            throw new InternalServerErrorException('AI Advices are disabled.');
        }
        $secretKey = $_ENV['OPENAI_API_KEY'] ?? throw new InternalServerErrorException('OpenAI API key not found.');
        $this->client = OpenAI::client($secretKey);
        $this->logger = $logger;
    }

    function getAdvice(array $errorReport): string
    {
        unset($errorReport['created_at']);
        unset($errorReport['id']);
        $errorInformation = substr(
            json_encode($errorReport),
            0,
            $GLOBALS['config']['advice']['charLimit']
        );
        $prompt = "Give me the solution for the following error report:\n" .
            $errorInformation . "\n" .
            "In case you don't have enough information to solve it," .
            "give me a clue on what file to check and what is the potential problem";
        $this->logger->info("Sending request to OpenAI");
        $this->logger->debug("Request values:", ["prompt" => $prompt]);
        $result = $this->client->chat()->create([
            'model' => $GLOBALS['config']['advice']['model'],
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $advice = $result->choices[0]->message->content ?? 'No advice available.';
        return $advice;
    }
}
