<?php
namespace App\Utility;

/**
 * Class SalaryRange
 *
 * This class handles the extraction of salary range, currency and time period from a given string.
 */
class SalaryRange
{
    private $salary;

    /**
     * SalaryRange constructor.
     *
     * @param string $salary
     */
    public function __construct(string $salary)
    {
        $this->salary = $salary;
    }

    /**
     * Magic method to get virtual properties.
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        $method = "get" . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

    /**
     * Extracts the currency from the salary string.
     *
     * @return string|null
     */
    private function getCurrency(): ?string
    {
        if (strpos($this->salary, '$') !== false || strpos($this->salary, 'USD') !== false) {
            return 'USD';
        }
        if (strpos($this->salary, '€') !== false || strpos($this->salary, 'EUR') !== false) {
            return 'EUR';
        }
        if (strpos($this->salary, '£')  !== false || strpos($this->salary, 'GBP') !== false) {
            return 'GBP';
        }

        return null;
    }

    /**
     * Determines if the salary is hourly.
     *
     * @return bool
     */
    private function getHourly(): bool
    {
        return strpos($this->salary, 'per hour') !== false;
    }

    /**
     * Extracts the numeric salary range from the salary string.
     *
     * @return array
     */
    private function getRange(): array
    {
        $pattern = '/\d[\d,\.]*/';
        preg_match_all($pattern, $this->salary, $matches);
        $matches = array_map(function($val) {
            return (float) str_replace(',', '', $val);
        }, $matches[0]);

        return [
            isset($matches[0]) ? $matches[0] : null,
            isset($matches[1]) ? $matches[1] : null
        ];
    }
}
