
[![Build Status](https://travis-ci.org/opensistemas-hub/cert-generator.svg?branch=master)](https://travis-ci.org/opensistemas-hub/cert-generator) 
 [![codecov](https://codecov.io/gh/opensistemas-hub/cert-generator/branch/master/graph/badge.svg)](https://codecov.io/gh/opensistemas-hub/cert-generator)



Example usage:

```PHP
<?php

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload


$vars = [
    'full_name'   => "Antonio Cortés",
    'course_name' => "Mi nombre de curso",

];

$settings = json_decode( __DIR__ . '/template1.json' , true );

$template = \Opensistemas\CertGenerator\Template::create( $settings, __DIR__ . '/test.pdf' ) ;

$template->generate( 'my.pdf', $vars  );

```


template1.json

```json

{
  "pages": [
    {
      "template": {
        "page": 1
      },
      "elements": [
        {
          "type": "text",
          "x": 20,
          "y": 50,
          "value": "Hola Mundo",
          "font": {
            "size": 20,
            "color": "#cc0000"
          }
        },
        {
          "type": "text",
          "x": 20,
          "y": 70,
          "value": {
            "key": "course_name"
          },
          "font": {
            "size": 20,
            "color": "#cc0000"
          }
        },
        {
          "type": "textBox",
          "x": 10,
          "y": 100,
          "w": 190,
          "h": 30,
          "align": "C",
          "value": {
            "key": "full_name"
          },
          "font": {
            "size": 34,
            "color": "#00CC00"
          }
        }
      ]
    },
    {
      "template": {
        "page": 2
      },
      "elements": [
        {
          "type": "textBox",
          "x": 10,
          "y": 100,
          "w": 280,
          "h": 30,
          "align": "C",
          "value": {
            "key": "full_name"
          },
          "font": {
            "size": 34,
            "color": "#102030",
            "bg": "#ffffff"
          }
        }
      ]
    }
  ]
}


```