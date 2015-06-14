<?php
/**
 * Created by PhpStorm.
 * User: Nav
 * Date: 14-6-2015
 * Time: 17:39
 *
 * BijdorpScraper for getting nice json
 * response of searchresults from the blijdorp
 * website. Made this for using the json output
 * in a android project. This scraper uses the
 * YQL Api as proxy for fetching results and we
 * just parse them to nice json format.
 */

class BlijdorpScraper {

    /*
     * Holds the YQL url
     * with resources
     */
    private $url;

    /*
     * Holds the keyword that we are passing
     */
    private $keyword;

    /*
     * Holds the results formatted in json
     */
    private $results;

    /*
     * Holds the response that we
     * get from the curl call.
     * Note that we will receive the
     * response in JSON format cuz we
     * hardcoded the &format=json for response from yql
     */
    private $response;


    public function __construct($keyword){
        $this->keyword = $keyword;
        $this->generateUrl();
        $this->makeTheCall();
        $this->setResults();
    }

    private function generateUrl()
    {
        $yql_base_url = "http://query.yahooapis.com/v1/public/yql";
        $yql_query = "select * from html where url='http://www.diergaardeblijdorp.nl/?s=".$this->keyword."' and xpath='/html/body/div[2]/div[1]/div[2]/h3'";
        $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
        $yql_query_url .= "&format=json";

        $this->url = $yql_query_url;
    }

    private function makeTheCall()
    {
        $session = curl_init($this->url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $this->response = json_decode(curl_exec($session));
    }

    private function setResults()
    {
        foreach ($this->response->query->results->h3 as $item) {
            $this->results[] = [
                'title'=>$item->a->content,
                'url'=>$item->a->href
            ];
        }
    }

    public function getResults()
    {
        return json_encode($this->results);
    }



}