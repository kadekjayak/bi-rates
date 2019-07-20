<?php

namespace Kadekjayak\BiRates;

class BiRates {

    /**
     * @var Null
     */
    private $rates = null;

    /**
     * Get Rates
     * 
     * @return Array
     */
    public function getRates( $currency = null )
    {
        if ( $this->rates == null ) {
            $this->updateRates();
        }

        if ( $currency != null ) {
            return @$this->rates[ $currency ];
        }

        return $this->rates;
    }

    /**
     * Update Rates
     * 
     * @return Array
     */
    public function updateRates()
    {
        $html = $this->getHtml();
        return $this->rates = $this->parseHtml( $html );
    }


    /**
     * Get Html
     * 
     * @return String
     */
    private function getHtml()
    {
        return file_get_contents( 'https://www.bi.go.id/id/moneter/informasi-kurs/transaksi-bi/Default.aspx' );
    }

    /**
     * Parse HTML
     * 
     * @param String
     * @return Array
     */
    private function parseHtml( $html )
    {
        $rates = [];

        $dom = new \DOMDocument();
        @$dom->loadHTML( $html );
        $dom = $dom->getElementById('ctl00_PlaceHolderMain_biWebKursTransaksiBI_GridView1');
        $rows = $dom->getElementsByTagName('tr');
        
        // Loop each rows
        foreach ( $rows as $index => $row ) {
            if ( $index == 0 ) continue;
            if ( ! empty( $row->nodeValue ) ) {
                
                $currency = trim( $row->childNodes->item(0)->nodeValue );
                $rates[ $currency ] = [
                    'sell' => $this->parseNumber( $row->childNodes->item(2)->nodeValue ),
                    'buy' => $this->parseNumber( $row->childNodes->item(3)->nodeValue )
                ];
            }
        }

        return $rates;
    }

    /**
     * Clean numeric values
     * 
     * @param Mixed
     * @return Float
     */
    private function parseNumber( $value ) 
    {
        return floatval( str_replace(',', '', trim( $value ) ) );
    }

}