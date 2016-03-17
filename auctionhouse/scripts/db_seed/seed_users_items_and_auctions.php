<?php

global $faker;
global $itemData;
global $reportFrequencies;



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
        "yoga mat",
        "pullup bar",
        "exercise book",
        "bicycle trainer",
        "treadmill"
    ),
    'Golf' =>array(
        "7 iron club",
        "6 iron club",
        "5 iron club",
        "2 iron club",
        "3 iron club",
        "4 iron club",
        "driver",
        "pitching wedge",
        "putter",
        "balls",
        "clubs"
    ),
    'Mobile Phones'=>array(
        "samsung phone",
        "samsung s4",
        "samsung s5",
        "samsung s2",
        "iphone",
        "sony phone"
    ),
    'Sound & Vision'=>array(
        "radio",
        "amplifier"
    ),
    'Video Games'=>array(
        "super mario kart",
        "halo",
        "grand theft auto 5",
        "need for speed",
        "tetris",
        "Zelda"

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





$dir    = $_SERVER['DOCUMENT_ROOT'] ."/images/item_images";
$itemImages = scandir($dir);
unset($itemImages[0]);
unset($itemImages[1]);

foreach($itemImages as &$itemImage){
    $itemImage = "/images/item_images/". $itemImage;
}

$dir    = $_SERVER['DOCUMENT_ROOT'] ."/images/profile_images";
$profileImages = scandir($dir);
unset($profileImages[0]);
unset($profileImages[1]);

foreach($profileImages as &$profileImage){
    $profileImage = "/images/profile_images/". $profileImage;
}


for ($i =0 ; $i < $numUsers ;$i++){

    $user = new DbUser(array(

        "username" => $faker->userName . $faker->numberBetween(0,100),
        "email"    => $faker->email,
        "firstName"=> $faker->firstName,
        "lastName" => $faker->lastName,
        "address"  => $faker->address,
        "postcode" => $faker->postcode,
        "city"     => $faker->city,
        "countryId" => $faker->randomElement(array(229, 14, 33 )),
        "password" => password_hash( "1111111111", PASSWORD_BCRYPT ),
        "verified" => 1,
        "image"     =>$faker->randomElement($profileImages)

    ));
    $user->create();

    $numItemsForUser = $faker->numberBetween(0, $maxItemsPerUser -1);
    for($z = 0 ; $z < $numItemsForUser ; $z++){

        $catName = $faker->randomElement(array_keys($catsAndItemNames));
        $itemCatId =  array_search($catName,array_keys($catsAndItemNames)) +1;

        /*if($faker->boolean(1)){

            $itemName = $faker->randomElement($catsAndItemNames[$catName]);
        }else{*/
        $itemName = $faker->randomElement($itemData)["Name"];
        //}
        $item = new DbItem(array(
            "userId" =>$user->getId(),
            "itemName" => $itemName,
            "itemBrand" =>$faker->randomElement($itemData)["Brand Name"],
            "categoryId" =>$itemCatId,
            "conditionId" => $faker->numberBetween(1,4),
            "itemDescription" => $faker->sentences(3, true),
            "image" => $faker->randomElement($itemImages)

        ));
        $item->create();
        $numAuctionForItem = $faker->numberBetween(0, $maxAuctionsPerItem -1);
        for ($x = 0 ; $x< $numAuctionForItem; $x++){

            $startPrice = 0.5 * $faker->numberBetween(1,200);
            if($faker->boolean($chanceOfGettingTrue = 80)){
                $reservePrice   =  $startPrice + 0.5 *$faker->numberBetween(1, 200);
            }else{
                $reservePrice   = 0;
            }
            $startTime = $faker->dateTimeBetween('-2 weeks', '+2 weeks');
            $endTime = new DateTime($startTime->format('Y-m-d H:i:s'));
            $endTime->add(date_interval_create_from_date_string("7 days"));
            //$endTime = $faker->dateTimeBetween('+1 day', '+15 days');
            if($faker->boolean(20)){
                $quantity = $faker->numberBetween(1, 10);
            }else{
                $quantity = 1;
            }
            $now = new DateTime();
            if($now > $startTime ){
                $numViews = $faker->numberBetween(100, 10000);
            }else{
                $numViews = 0;
            }
            $auction = new DbAuction(array(

                "itemId" => $item->getId(),
                "quantity" => $quantity,
                "startPrice" => $startPrice,
                "reservePrice" => $reservePrice,
                "startTime" => $startTime->format('Y-m-d H:i:s'),
                "endTime"   => $endTime->format('Y-m-d H:i:s'),
                "views"     =>$numViews,
                "reportFrequency" => $faker->randomElement(array_values($reportFrequencies))

            ));
            $auction->create();


        }
    }

}