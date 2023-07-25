<?php
namespace Tests\Unit\Utility;

use App\Utility\SalaryRange;
use Tests\TestCase;

/**
 * Class SalaryRangeTest
 *
 * Test cases for the SalaryRange utility class.
 */
class SalaryRangeTest extends TestCase
{
    /**
     * Test handling of hourly salary in USD.
     */
    public function testHourlySalary()
    {
        $salary = new SalaryRange("$30 - $45 USD per hour");
        $this->assertEquals('USD', $salary->currency);
        $this->assertTrue($salary->hourly);
        $this->assertEquals([30, 45], $salary->range);
    }

    /**
     * Test handling of annual salary in USD.
     */
    public function testAnnualSalary()
    {
        $salary = new SalaryRange("$95,000-$115,000");
        $this->assertEquals('USD', $salary->currency);
        $this->assertFalse($salary->hourly);
        $this->assertEquals([95000, 115000], $salary->range);
    }

    /**
     * Test handling of annual salary in EUR.
     */
    public function testEurAnnualSalary()
    {
        $salary = new SalaryRange("€ 29,460.00 - € 73,236.00 (Gross 2, annual)");
        $this->assertEquals('EUR', $salary->currency);
        $this->assertFalse($salary->hourly);
        $this->assertEquals([29460, 73236], $salary->range);
    }

    /**
     * Test handling of annual salary in GBP.
     */
    public function testGbpAnnualSalary()
    {
        $salary = new SalaryRange("£50,000 - £70,000");
        $this->assertEquals('GBP', $salary->currency);
        $this->assertFalse($salary->hourly);
        $this->assertEquals([50000, 70000], $salary->range);
    }

    /**
     * Test handling of missing currency symbol.
     */
    public function testMissingCurrencySymbol()
    {
        $salary = new SalaryRange("30 - 45 per hour");
        $this->assertEquals(null, $salary->currency);
        $this->assertTrue($salary->hourly);
        $this->assertEquals([30, 45], $salary->range);
    }

    /**
     * Test handling of missing range.
     */
    public function testMissingRange()
    {
        $salary = new SalaryRange("$ per hour");
        $this->assertEquals('USD', $salary->currency);
        $this->assertTrue($salary->hourly);
        $this->assertEquals([null, null], $salary->range);
    }

    /**
     * Test handling of different placement of currency symbol.
     */
    public function testCurrencySymbolPlacement()
    {
        $salary = new SalaryRange("30 - 45 USD per hour");
        $this->assertEquals('USD', $salary->currency);
        $this->assertTrue($salary->hourly);
        $this->assertEquals([30, 45], $salary->range);
    }

    /**
     * Test handling of irrelevant text included.
     */
    public function testIrrelevantTextIncluded()
    {
        $salary = new SalaryRange("$30 - $45 USD per hour, full time");
        $this->assertEquals('USD', $salary->currency);
        $this->assertTrue($salary->hourly);
        $this->assertEquals([30, 45], $salary->range);
    }

    /**
     * Test handling of mixed range (hourly and annual).
     */
    public function testMixedRange()
    {
        $salary = new SalaryRange("$30 - $45,000 USD");
        $this->assertEquals('USD', $salary->currency);
        $this->assertFalse($salary->hourly);  // Since the smallest value is considered hourly
        $this->assertEquals([30, 45000], $salary->range);
    }
}
