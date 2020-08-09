<?php

namespace App\Http\Controllers\Api\Wheel;

use App\Model\SpinWheel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $randomColor = [
            '#364C62', 
            '#F1C40F', 
            '#E67E22', 
            '#E74C3C', 
            '#95A5A6', 
            '#16A085', 
            '#27AE60', 
            '#2980B9', 
            '#8E44AD', 
            '#2C3E50', 
            '#F39C12', 
            '#D35400', 
            '#C0392B', 
            '#BDC3C7',
            '#1ABC9C', 
            '#2ECC71', 
            '#E87AC2', 
            '#3498DB', 
            '#9B59B6', 
            '#7F8C8D'
        ];
        shuffle($randomColor);
        $segmentValues = SpinWheel::inRandomOrder()->get();
        $data = [
            'colorArray' => $randomColor,
            'segmentValuesArray' => $segmentValues,
            'svgWidth' => 1024,
            'svgHeight' => 768,
            'wheelStrokeColor' => '#ffcc44',
            'wheelStrokeWidth' => 18,
            'wheelSize' => 700,
            'wheelTextOffsetY' => 80,
            'wheelTextColor' => '#EDEDED',
            'wheelTextSize' => '2.3em',
            'wheelImageOffsetY' => 40,
            'wheelImageSize' => 100,
            'centerCircleSize' => 360,
            'centerCircleStrokeColor' => '#ffcc44',
            'centerCircleStrokeWidth' => 12,
            'centerCircleFillColor' => '#EDEDED',
            'segmentStrokeColor' => '#E2E2E2',
            'segmentStrokeWidth' => 4,
            'centerX' => 512,
            'centerY' => 384,  
            'hasShadows' => false,
            'numSpins' => 999999 ,
            'spinDestinationArray' => [],
            'minSpinDuration' => 6,
            'gameOverText' => 'THANK YOU FOR PLAYING SPIN2WIN WHEEL. COME AND PLAY AGAIN SOON!',
            'invalidSpinText' =>'INVALID SPIN. PLEASE SPIN AGAIN.',
            'introText' => 'Xin chào',
            'hasSound' => true,
            'gameId' => '9a0232ec06bc431114e2a7f3aea03bbe2164f1aa',
            'clickToSpin' => true
        ];

        return response()->json($data);
    }
}
