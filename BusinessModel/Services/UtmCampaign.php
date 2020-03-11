<?php

namespace HabanaTech\BusinessModel\Services;

use Symfony\Component\HttpFoundation\Request;


class UtmCampaign
{
    private $utm_source;
    private $utm_medium;
    private $utm_campaign;

    public function __construct(Request $request)
    {
        $this->utm_source = $request->get('utm_source');
        $this->utm_medium = $request->get('utm_medium');
        $this->utm_campaign = $request->get('utm_campaign');
    }

    public function getContent()
    {
        $tmp = $this->utm_campaign;
        if($this->utm_medium)
            $tmp .=  " | medium: ".$this->utm_medium;
        if($this->utm_source)
            $tmp .=  " | source: ".$this->utm_source;

        return $tmp;
    }

    public function getCampaign(){
        return [
            'utm_source' => $this->utm_source,
            'utm_medium' => $this->utm_medium,
            'utm_campaign' => $this->utm_campaign
        ];
    }
}