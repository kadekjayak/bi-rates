<?php

use PHPUnit\Framework\TestCase;

class BiRatesTest extends TestCase
{
    /**
     * Get Component
     * 
     * @return \Kadekjayak\BiRates\BiRates
     */
    public function getComponent()
    {
        return new \Kadekjayak\BiRates\BiRates();
    }

    /**
     * Test Get Rates, make sure the JSON structure is correct
     */
    public function testGetRates()
    {
        $response = $this->getComponent()->getRates();
        $this->assertTrue( is_array( $response ) );
        $this->assertArrayHasKey( 'USD', $response );

        foreach( $response as $rate ) {
            $this->assertArrayHasKey('sell', $rate);
            $this->assertArrayHasKey('buy', $rate);
            $this->assertIsNumeric( $rate['sell'] );
            $this->assertIsNumeric( $rate['buy'] );
        }
        
    }

    /**
     * Test to Get single currency
     */
    public function testGetRate()
    {
        $response = $this->getComponent()->getRates( 'USD' );
        $this->assertTrue( is_array( $response ) );
        $this->assertArrayHasKey('sell', $response);
        $this->assertArrayHasKey('buy', $response);
    }

    /**
     * Test Invalid Currency
     * the component should return null
     */
    public function testGetInvalidRate()
    {
        $response = $this->getComponent()->getRates( 'FUCK' );
        $this->assertNull( $response );
    }

    /**
     * Test Continuously
     */
    public function testContinuously()
    {
        $component = $this->getComponent();
        $response = $component->getRates();
        $this->assertTrue( is_array( $response ) );
        $this->assertArrayHasKey( 'USD', $response );

        foreach( $response as $rate ) {
            $this->assertArrayHasKey('sell', $rate);
            $this->assertArrayHasKey('buy', $rate);
            $this->assertIsNumeric( $rate['sell'] );
            $this->assertIsNumeric( $rate['buy'] );
        }

        $response = $component->getRates('EUR');
        $this->assertTrue( is_array( $response ) );
        $this->assertArrayHasKey('sell', $response);
        $this->assertArrayHasKey('buy', $response);

        $response = $component->getRates( 'FUCK' );
        $this->assertNull( $response );
    }
}
