<?php

namespace App\Data;

class DestinationsData
{
    public static function getAllDestinations()
    {
        return [
            'angkor-wat' => [
                'id' => 'angkor-wat',
                'name' => 'Angkor Wat',
                'tag' => 'Must Visit',
                'tag_color' => 'yellow',
                'description' => 'The crown jewel of Khmer architecture, a UNESCO World Heritage site.',
                'full_description' => 'Angkor Wat is the largest religious monument in the world, built in the early 12th century. This architectural masterpiece is the pride of the Khmer Empire, showcasing intricate bas-reliefs and stunning architectural designs.',
                'location' => 'Siem Reap Province',
                'best_time' => 'November to February',
                'image' => 'https://i.pinimg.com/736x/c2/f1/63/c2f16305e562b895a4884b81ddbf5fbd.jpg',
                'gallery' => [
                    'https://i.pinimg.com/736x/c2/f1/63/c2f16305e562b895a4884b81ddbf5fbd.jpg',
                    'https://i.pinimg.com/736x/2a/1a/54/2a1a5458dc6d52fbba16190743969400.jpg'
                ],
                'activities' => [
                    'Sunrise viewing',
                    'Guided temple tours',
                    'Photography sessions'
                ],
                'travel_tips' => [
                    'planning' => [
                        'recommended_time' => 'November to February (cool, dry season)',
                        'budget' => '$70 - $150 (transportation, tickets, food, accommodation)',
                        'duration' => '1-3 days to explore the Angkor Archaeological Park'
                    ],
                    'transportation' => [
                        'tuk_tuk' => [
                            'description' => 'Hire a tuk-tuk for a day tour from Siem Reap',
                            'cost' => '$15–$25/day'
                        ],
                        'private_car' => [
                            'description' => 'Book a private car with driver for comfort',
                            'cost' => '$30–$50/day'
                        ],
                        'bicycle' => [
                            'description' => 'Rent a bicycle for a scenic ride through the park',
                            'cost' => '$2–$5/day'
                        ]
                    ],
                    'accommodation' => [
                        'options' => [
                            [
                                'name' => 'Tara Angkor Hotel',
                                'description' => 'Mid-range, modern amenities, near the park'
                            ],
                            [
                                'name' => 'J7 Hotel',
                                'description' => 'Luxury option with cultural design'
                            ],
                            [
                                'name' => 'Mad Monkey Hostel',
                                'description' => 'Budget-friendly, social vibe for backpackers'
                            ]
                        ],
                        'booking_platforms' => [
                            ['name' => 'Agoda', 'link' => 'https://www.agoda.com'],
                            ['name' => 'Booking.com', 'link' => 'https://www.booking.com']
                        ]
                    ],
                    'visiting' => [
                        'ticket' => 'Purchase an Angkor Pass: $37 (1-day), $62 (3-day), $72 (7-day)',
                        'transport_to_site' => 'Tuk-tuk, car, or bicycle from Siem Reap (~20-30 min)',
                        'guide' => 'Hire a licensed guide for $25–$40/day for in-depth history',
                        'activities' => 'Explore Angkor Wat, Bayon, Ta Prohm, and smaller temples',
                        'essentials' => 'Wear comfortable shoes, bring water, sunscreen, and a hat'
                    ],
                    'food_and_culture' => [
                        'dishes' => ['Amok fish', 'Lok lak', 'Khmer noodle salad'],
                        'dining' => 'Dine at Pub Street or local markets like Psar Chas',
                        'cultural_experience' => 'Attend an Apsara dance performance in Siem Reap'
                    ],
                    'bonus_tips' => [
                        'Buy the Angkor Pass at the official ticket center or online to avoid scams',
                        'Start early (5 AM) for sunrise at Angkor Wat to beat crowds',
                        'Dress respectfully (cover shoulders and knees) for temple visits',
                        'Use a map or app to plan your temple route efficiently'
                    ]
                ]
            ],
            'sambor-prei-kuk' => [
                'id' => 'sambor-prei-kuk',
                'name' => 'Sambor Prei Kuk',
                'tag' => 'Historical',
                'tag_color' => 'green',
                'description' => 'Ancient temple city and UNESCO World Heritage site in Kampong Thom.',
                'full_description' => 'Sambor Prei Kuk, the ancient capital of Chenla, features remarkable pre-Angkorian architecture. This UNESCO World Heritage site comprises more than 100 temples scattered throughout the forest.',
                'location' => 'Kampong Thom Province',
                'best_time' => 'December to March',
                'image' => 'https://i.pinimg.com/736x/34/80/62/348062ca1351014ef60061ebb84d61d0.jpg',
                'gallery' => [
                    'https://i.pinimg.com/736x/34/80/62/348062ca1351014ef60061ebb84d61d0.jpg',
                    'https://i.pinimg.com/736x/2a/1a/54/2a1a5458dc6d52fbba16190743969400.jpg'
                ],
                'activities' => [
                    'Temple exploration',
                    'Historical tours',
                    'Nature walks'
                ],
                'travel_tips' => [
                    'planning' => [
                        'recommended_time' => 'November to March (cooler weather)',
                        'budget' => '$50 - $100 (transportation, food, accommodation)',
                        'duration' => '1-day trip or overnight stay'
                    ],
                    'transportation' => [
                        'bus' => [
                            'description' => 'Book via BookMeBus',
                            'cost' => '$6–$8',
                            'link' => 'https://www.bookmebus.com'
                        ],
                        'taxi_private_car' => [
                            'description' => 'Hire a taxi or private car',
                            'cost' => '~$60 one way',
                            'duration' => '3–4 hour drive'
                        ],
                        'motorbike' => [
                            'description' => 'Rent a motorbike for the adventurous',
                            'cost' => '$10–$15/day'
                        ]
                    ],
                    'accommodation' => [
                        'options' => [
                            [
                                'name' => 'Arunras Hotel',
                                'description' => 'Budget-friendly, central location'
                            ],
                            [
                                'name' => 'Glorious Hotel',
                                'description' => 'Mid-range with better facilities'
                            ]
                        ],
                        'booking_platforms' => [
                            ['name' => 'Agoda', 'link' => 'https://www.agoda.com'],
                            ['name' => 'Booking.com', 'link' => 'https://www.booking.com']
                        ]
                    ],
                    'visiting' => [
                        'transport_to_site' => 'Hire a tuk-tuk or motorbike taxi (~$10–$15 round trip)',
                        'entry_fee' => '~$5 per person',
                        'guide' => 'Hire a local guide for $5–$10 for better experience',
                        'activities' => 'Explore ancient temples surrounded by forest',
                        'essentials' => 'Bring water, hat, and sunscreen'
                    ],
                    'food_and_culture' => [
                        'dishes' => ['Grilled fish', 'Prahok', 'Khmer curry'],
                        'market' => 'Visit the Kampong Thom market for local snacks',
                        'local_interaction' => 'Interact with friendly locals and support small businesses'
                    ],
                    'bonus_tips' => [
                        'Bring cash—ATMs may be limited in rural areas',
                        'Respect the temples—no climbing on ruins',
                        'Capture photos but avoid drones without permission'
                    ]
                ]
            ]
            // Add more destinations as needed
        ];
    }

    public static function getDestination($id)
    {
        $destinations = self::getAllDestinations();
        return $destinations[$id] ?? null;
    }
}