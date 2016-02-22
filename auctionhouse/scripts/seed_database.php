<?php


$faker = Faker\Factory::create();


$catsAndItemNames = array(
    'Collectables'=> array(
        "Black Penny Stamp",
        "Silver Spoons",
        "Old model plane",
        "World War 1 Photographs"

    ),
    'Antiques' => array(
        "Silver cigarette case",
        "antique razor",
        "Tijuana Mexico Pesos Coin Card",
        "Antique cast iron eyebolt Barn Pulley",
        "Antique Brass Early 1900's Hand Held Teacher's Bell"
        ),

    'Sports Memorabilia'=> array(
        "england football shirt 1980",
        "austrian football shirt 1988",
        "bulgarian football shirt 1992",

    ),
    'Coins'     => array(
        "roman coin",
        "old penny",
        "bunch of shillings"
    ),

    'Garden' => array(
        "lawn seed",
        "honeysuckle plant",
        "apple tree",
        "blueberry plants",
        "tomato seedlings",
        "tree pruning saw",
        "lawnmower"

    ),
    'Appliances' => array(
        "microwave",
        "dishwasher",
        "oven",
        "fridge",
        "toaster"
    ),
    'DIY Materials' => array(
        "mdf board",
        "plexiglass",
        "paint",
        "cement",
        "wood glue",
        "wood stain"
    ),
    'Furniture & Homeware' => array(
        "cupboard",
        "sofa",
        "tv cabinet",
        "coffee table"
    ),
    'Cycling' => array(
        "bicycle",
        "spare tyre",
        "bike pump"
    ),

    'Fishing' =>array(
        "fishing rod",
        "fishing line",
        "tackle box"
    ),
    'Fitness, Running & Yoga' => array (
        "weights",
        "yoga mat"
    ),
    'Golf' =>array(
        "balls",
        "clubs"
    ),
    'Mobile Phones'=>array(
        "samgung phone",
        "iphone",
        "sony phone"
    ),
    'Sound & Vision'=>array(
        "radio",
        "amplifier"
    ),
    'Video Games'=>array(
        "super mario kart",
        "halo"
    ),
    'Computer & Tables'=>array(
        "Apple iPad",
        "HP Slate",
        "Dell Streak"
    ),
    'Watches'=>array(
        "Zen watch",
        "Some Watch",
        "swatch"
    ),
    'Costume Jewellery'=>array(
        "old sheriff badge"
    ),
    'Vintage & Antique Jewelery'=>array(
        "circa 1900 necklace"
    ),
    'Fine Jewelery'=>array(
        "diamond ring",
        "silver broache"
    ),
    'Radio Controlled'=>array(
        "remote controlled car"
    ),
    'Construction Toys'=>array(
        "Lego"
    ),
    'Outdoor Toys'=>array(
        "cricket set",
        "croquet set"
    ),
    'Action Figures'=>array(
        "GI Joe"
    ),
    'Women\'s Clothing'=>array(
        "women's Jacket"
    ),
    'Men\'s Clothing'=>array(
        "Gap Jacket",
        "used underpants"
    ),
    'Shoes'=>array(
        "reebok classics",
        "nike running shoes"
    ),
    'Kid\'s Fashion'=>array(
        "kid's shoes"
    ),
    'Cars'=>array(
        "VW golf",
        "BMW 316 e36"
    ),
    'Car Parts'=>array(
        "battery",
        "spare tyre"
    ),
    'Motorcycles & Scooters'=>array(
        "Yamaha bike",
        "suzuki motorbike"
    ),
    'Motorcycle Parts'=>array(
        "start motor",
        "gear cog"
    ),
    'Books, Comics & Magazines'=>array(
        "spiderman comic"
    ),
    'Health & Beauty'=>array(
        "makeup"
    ),
    'Musical Instruments'=>array(
        "guitar",
        "keyboard"
    ),
    'Business, Office & Industrial'=>array(
        "stapler",
        "filing cabinet"
    )
);

$numUsers = 100;
$maxItemsPerUser = 5;
$maxAuctionsPerItem = 3;
$maxBidsPerAuction = 15;
for ($i =0 ; $i < $numUsers ;$i++){

    $user = new DbUser(array(

        "username" => $faker->userName,
        "email"    => $faker->email,
        "firstName"=> $faker->firstName,
        "lastName" => $faker->lastName,
        "address"  => $faker->address,
        "postcode" => $faker->postcode,
        "city"     => $faker->city,
        "countryId" => $faker->randomElement(array(229, 14, 33 )),
        "password" => password_hash( "1111111111", PASSWORD_BCRYPT ),
        "verified" => 1,
        "image"     =>$faker->imageUrl($width = 640, $height = 480, 'people')

    ));
    $user->create();

    $numItemsForUser = $faker->numberBetween(0, $maxItemsPerUser -1);
    for($z = 0 ; $z < $numItemsForUser ; $z++){

        $catName = $faker->randomElement(array_keys($catsAndItemNames));
        $itemCatId =  array_search($catName,array_keys($catsAndItemNames)) +1;
        $itemName = $faker->randomElement($catsAndItemNames[$catName]);
        $item = new DbItem(array(
            "userId" =>$user->getId(),
            "itemName" => $itemName,
            "itemBrand" =>$faker->company,
            "categoryId" =>$itemCatId,
            "conditionId" => $faker->numberBetween(1,4),
            "itemDescription" => $faker->sentences(3, true),
            "image" => $faker->imageUrl()

        ));
        $item->create();
        $numAuctionForItem = $faker->numberBetween(0, $maxAuctionsPerItem -1);
        for ($x = 0 ; $x< $numAuctionForItem; $x++){

            $startPrice = $faker->randomFloat(2, 0.00, 99.00);
            if($faker->boolean($chanceOfGettingTrue = 80)){
                $reservePrice   = $faker->randomFloat(2,$startPrice, 100.00 );
            }else{
                $reservePrice   = 0;
            }
            $startTime = $faker->dateTimeBetween('-2 months', '+2 months');
            $endTime = $startTime->add(date_interval_create_from_date_string("7 days"));
            //$endTime = $faker->dateTimeBetween('+1 day', '+15 days');
            $auction = new DbAuction(array(

                "itemId" => $item->getId(),
                "quantity" => $faker->numberBetween(1, 10),
                "startPrice" => $startPrice,
                "reservePrice" => $reservePrice,
                "startTime" => $startTime->format('Y-m-d H:i:s'),
                "endTime"   => $endTime->format('Y-m-d H:i:s'),
                "sold"      => 0

            ));
            $auction->create();

            /*if($faker->boolean(80)){
                $numBidsForAuction = $faker->numberBetween(1, $maxBidsPerAuction);
                $lastBidTime = $faker->dateTimeBetween($startTime, 'now');
                $lastBidPrice = $faker->randomFloat(2,$startPrice, 200.00);

                for($d = 0 ; $d< $numBidsForAuction ; $d++){


                    $bid = new DbBid(array(

                        "userId" => $user->getId(),
                        "auctionId" => $auction->getId(),
                        "bidTime" => $lastBidTime->format('Y-m-d H:i:s'),
                        "bidPrice" => $lastBidPrice


                    ));
                    $bid->create();
                    $lastBidTime = $faker->dateTimeBetween($lastBidTime, 'now');
                    $lastBidPrice = $faker->randomFloat(2,$lastBidPrice, 200.00);

                }
            }*/



        }
    }

}


///create bids

$numBids = 500;
$userIds = DbUser::listIds();
$auctionIds = DbAuction::listIds();

for ($i =0 ; $i < $numUsers ;$i++){

    //get random auction ;
    $auction = DbAuction::find($faker->randomElement($auctionIds));
    $user = DbUser::find($faker->randomElement($userIds));
    $currentBid = $auction->getField("startPrice");

    $user = DbUser::find($faker->randomElement($userIds));
    $items = DbItem::withConditions("WHERE userId IS NOT ". $user->getId())->getAsClasses();
    //pick random item
    //$item
    //$auctions = DbAuction::withConditions("WHERE ")
}


function makeBidsForAuction($auction, $numBids, $userIds){

    $faker = Faker\Factory::create();
    $numBids = $faker->numberBetween(1, 20);
    //make bids evenly spaced apart in time for simplicity.
    $user = DbUser::find($faker->randomElement($userIds));
    $price = $auction->getField("startPrice") + $faker->numberBetween(1, 10);
    $startTime = date_create_from_format('Y-m-d H:i:s',$auction->getField("startTime") );
    $endTime = date_create_from_format('Y-m-d H:i:s',$auction->getField("endTime") );
    date_sub($endTime, date_interval_create_from_date_string("5 seconds"));
    //$endTime->sub("5 seconds");

    $bidInterval = $endTime->diff($startTime)->s;
    var_dump($bidInterval);

}




