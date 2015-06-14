<?php
require_once 'BlijdorpScraper.php';
/*
 *
 * Abstraction layer for the search results from
 * diergaardeblijdorp.nl in JSON format.
 *
 * Request by post or get
 * passing the keyword to get
 * results from the search of blijdorp
 *
 * Returns result in a arrays with title and url
 */


    if(isset($_REQUEST['keyword'])){
       $blijdorp = new BlijdorpScraper($_REQUEST['keyword']);
        die(
            $blijdorp->getResults()
        );
    } else{
        die( 'No Keyword provided, please add ?keyword= to the url with your keyword' );
    }