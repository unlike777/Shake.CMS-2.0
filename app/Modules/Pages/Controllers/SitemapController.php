<?php

namespace App\Modules\Pages\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pages\Models\Page;
use SimpleXMLElement;
use Date;

class SitemapController extends Controller  {

    public function def() {
        return view('pages::sitemap.default');
    }
    
    public function xml() {
        
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        
        $data = Page::publ()->orderBy('position')->get();
        
        /**
         * @var $obj Page
         */
        
        foreach ($data as $obj) {
            $child = $xml->addChild('url');
            $child->addChild('loc', $obj->url());
            $child->addChild('lastmod', Date::parse($obj->updated_at)->format('c'));
            if ($obj->is_home) {
                $child->addChild('changefreq', 'monthly');
            } else {
                $child->addChild('changefreq', 'monthly');
            }
            $child->addChild('priority', '0.50');
        }
        
        /*
        $data = Video::publ()->orderBy('publ_date', 'desc')->get();

//        $min_date = strtotime(Unit::min('updated_at'));
//        $max_date = strtotime(Unit::max('updated_at')) - $min_date;
        
        foreach ($data as $obj) {
            $child = $xml->addChild('url');
            $child->addChild('loc', $obj->url());

//            $upd_date = strtotime($obj->updated_at) - $min_date;
//            
//            $t = round($upd_date / $max_date, 2);
//            if (empty ($t)) {
//                $t = '0.10';
//            }
            
            $child->addChild('lastmod', Date::parse($obj->updated_at)->format('c'));
            
            $freq = 'weekly';

//            $freq = 'daily';
//            if ($t < 0.2) {
//                $freq = 'yearly';
//            } else if ($t < 0.5) {
//                $freq = 'monthly';
//            } else if ($t < 0.8) {
//                $freq = 'weekly';
//            }
            
            $t = '0.7';
            
            $child->addChild('changefreq', $freq);
            $child->addChild('priority', number_format($t, 2));
        }
        */
        
        return response($xml->asXML())
            ->withHeaders(['Content-type' => 'text/xml; charset=UTF-8']);
    }
    
}
