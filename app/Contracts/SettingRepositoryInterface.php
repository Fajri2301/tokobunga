<?php

namespace App\Contracts;

interface SettingRepositoryInterface
{
    public function getGlobalSettings();
    public function clearCache(): void;
}
