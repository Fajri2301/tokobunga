<?php

namespace App\Contracts;

interface AIChatServiceInterface
{
    /**
     * Get a response from the AI bot.
     *
     * @return string|null
     */
    public function getResponse(string $message, array $contextData = [], array $history = []): string|array|null;
}
