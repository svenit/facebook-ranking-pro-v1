<?php

namespace App\Http\Controllers\User\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WheelController extends Controller
{
    public function index()
    {
        return view('user.events.wheel');
    }
    public function data()
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
        $segmentValues = [
            [
                'probability' => 20,
                'type' => 'string',
                'value' => 'HOLIDAY^FOR TWO',
                'win' => false,
                'resultText' => 'YOU WON A HOLIDAY!',
                'userData' => [
                    'score' => 10
                ]
            ],
            [
                'probability' => 120,
                'type' => 'image',
                'value' => 'http://pixelartmaker.com/art/2b6c9fa2d26bf98.png',
                'win' => true,
                'resultText' => 'Gold',
                'userData' => [
                    'score' => 20
                ]
            ],
            [
                'probability' => 120,
                'type' => 'string',
                'value' => '2M XU',
                'win' => true,
                'resultText' => 'A SQUARE!',
                'userData' => [
                    'score' => 3000
                ]
            ],
            [
                'probability' => 120,
                'type' => 'image',
                'value' => 'https://clipart.info/images/ccovers/1499793247facebook-sad-emoji-like-png.png',
                'win' => true,
                'resultText' => 'A SQUARE!',
                'userData' => [
                    'score' => 3000
                ]
            ],
            [
                'probability' => 120,
                'type' => 'image',
                'value' => 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/7d638993-ee6c-4f33-a918-7526f0bb9e50/d4lyhdi-67246a08-321e-488c-aeea-3ba9093c3288.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzdkNjM4OTkzLWVlNmMtNGYzMy1hOTE4LTc1MjZmMGJiOWU1MFwvZDRseWhkaS02NzI0NmEwOC0zMjFlLTQ4OGMtYWVlYS0zYmE5MDkzYzMyODgucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.QmjMUPrNd6CbAre175pEH18Y0_XHH4Htb6uq_rd2gew',
                'win' => true,
                'resultText' => 'A SQUARE!',
                'userData' => [
                    'score' => 3000
                ]
            ]
        ];
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
