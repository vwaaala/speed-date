<?php

namespace App\Traits;

use Illuminate\Support\Facades\Artisan;

trait LaraEnvTrait
{
    /**
     * Get values from the laravel config for the specified keys.
     *
     * @param array $keys
     * @return array
     */
    protected function getFromConfig(array $keys): array
    {
        $values = [];

        foreach ($keys as $key) {
            // Use the config function to get the value from the configuration
            $values[$key] = config($key);
        }

        return $values;
    }

    /**
     * Get values directly from the .env file for the specified keys.
     *
     * @param array $keys
     * @return array
     */
    protected function getFromEnv(array $keys): array
    {
        $values = [];

        // Read the contents of the .env file
        $envContents = file_get_contents(base_path('.env'));

        foreach ($keys as $key) {
            // Regular expression to match the key and extract the value
            $pattern = "/^{$key}=(.*)/m";

            // Use preg_match to find matches in the .env contents
            preg_match($pattern, $envContents, $matches);

            // If a match is found, set the value in the array, otherwise, set null
            $values[$key] = isset($matches[1]) ? $matches[1] : null;
        }

        return $values;
    }

    /**
     * Get all key-value pairs from the .env file.
     *
     * @return array
     */
    protected function getAllFromEnv(): array
    {
        $values = [];

        // Read the contents of the .env file
        $envContents = file_get_contents(base_path('.env'));

        // Match all key-value pairs using regular expression
        preg_match_all('/^(?!#)([^\s=]+)=(.*)$/m', $envContents, $matches, PREG_SET_ORDER);

        // Iterate over matched pairs and populate the $values array
        foreach ($matches as $match) {
            $values[$match[1]] = $match[2];
        }

        return $values;
    }


    /**
     * Set values in the environment for the specified keys.
     *
     * @param array $data
     */
    protected function setOnEnv(array $data): void
    {
        foreach ($data as $key => $value) {
            // Set the value in the configuration
            config([$key => $value]);

            // Optionally, update the .env file
            $this->updateEnvFile($key, $value);
        }

        // Clear the configuration cache (optional, but recommended)
        Artisan::call('config:clear');
        Artisan::call('config:cache');
    }

    /**
     * Update the .env file with the new key-value pair.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function updateEnvFile(string $key, $value): void
    {
        $envFilePath = base_path('.env');

        // Read the current contents of the .env file
        $contents = file_get_contents($envFilePath);

        // Replace the old value with the new value
        $contents = preg_replace("/{$key}=(.*)/", "{$key}={$value}", $contents);

        // Write the updated contents back to the .env file
        file_put_contents($envFilePath, $contents);
    }
}
