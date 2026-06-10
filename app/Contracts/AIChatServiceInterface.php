<?php

namespace App\Contracts;

interface AIChatServiceInterface
{
    /**
     * Get a response from the AI bot.
     *
     * @param string $message
     * @param array $contextData
     * @param array $history
     * @return string|null
     */
    public function getResponse(string $message, array $contextData = [], array $history = []): ?string;
}
