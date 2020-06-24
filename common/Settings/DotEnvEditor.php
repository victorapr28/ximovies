<?php namespace Common\Settings;

use Dotenv\Dotenv;

/**
 * Class DotEnvEditor
 * @package Common\Settings
 */
class DotEnvEditor
{
    /**
     * Load values from .env file
     * @return array
     */
    public function load()
    {
        $dotenv = Dotenv::createImmutable(base_path());
        $env = $dotenv->load();
        return $env;
    }

    /**
     * Write specified settings to .env file
     * @param array $values
     */
    public function write($values = [])
    {
        $content = file_get_contents($this->filePath);

        foreach ($values as $key => $value) {
            $value = $this->formatValue($value);
            $key = strtoupper($key);

            if (str_contains($content, $key.'=')) {
                preg_match("/($key=)(.*?)(\n|\Z)/msi", $content, $matches);
                $content = str_replace($matches[1].$matches[2], $matches[1].$value, $content);
            } else {
                $content .= "\n\n$key=$value";
            }
        }
        $filePath = base_path(".env");

        file_put_contents($this->filePath, $content);
    }

    /**
     * Format specified value to be capatible with .env file
     *
     * @param $value
     * @return string
     */
    private function formatValue($value)
    {
        if ($value === 0 || $value === false) $value = 'false';
        if ($value === 1 || $value === true) $value = 'true';
        if ( ! $value) $value = 'null';

        // wrap string in quotes, if it contains whitespace
        if (preg_match('/\s/', $value)) {
            //replace double quotes with single quotes
            $value = str_replace('"', "'", $value);

            //wrap string in quotes
            $value = '"'.$value.'"';
        }

        return $value;
    }
}
