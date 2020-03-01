<?php

namespace App\DataFixtures;

use App\Entity\Traduction;
use App\Entity\Type;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {



        $types = [
            'substantif' => [
                'бабушка' => [
                    'traductions' => [
                        'grand-mère' => 'mamie mais en plus formel',
                    ],
                ],
                'человек' => [
                    'traductions' => [
                        'homme',
                        'personne',
                    ],
                ],
            ],
            'adjectif' => [
                'большой' => [
                    'traductions' => [
                        'grand',
                    ],
                ],
            ],
            'adverbe' => [
                'здесь' => [
                    'traductions' => [
                        'ici',
                    ],
                ],
            ],
            'nom propre' => [
                'Катерина',
            ],
            'pronom' => [
                "мой" => [
                    'traductions' => [
                        'mon',
                        'le mien',
                    ],
                ],
            ],
            'verbe' => [
                'знать' => [
                    'traductions' => [
                        'savoir',
                        'connaître',
                    ]
                ]
            ]
        ];

        foreach ($types as $name => $words) {

            $type = new Type;


            if (is_array($words)) {
                $type->setName($name);
                foreach ($words as $wordName => $wordOptions) {
                    $word = new Word;
                    $word->setType($type);
                    if (is_array($wordOptions)) {
                        $word->setSpelling($wordName);
                        foreach ($wordOptions as $option => $optionValue) {
                            if ($option == "traductions") {
                                foreach ($optionValue as $tradKey => $tradValue) {
                                    $traduction = new Traduction;
                                    if (is_string($tradKey)) {
                                        $traduction->setSpelling($tradKey);
                                        $traduction->setDescription($tradValue);
                                    } else {
                                        $traduction->setSpelling($tradValue);
                                    }
                                    $word->addTraduction($traduction);
                                    $manager->persist($traduction);
                                }
                            }
                        }
                    } else {
                        $word->setSpelling($wordOptions);
                    }
                    $manager->persist($word);
                }
            } else {
                $type->setName($words);
            }

            $manager->persist($type);
        }

        $manager->flush();
    }
}
