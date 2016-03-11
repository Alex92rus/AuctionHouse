SELECT  auctions.auctionId, quantity , startTime,
                endTime, itemName, itemBrand, itemDescription, items.image, auctions.views,
                item_categories.categoryName as subCategoryName, superCategoryName,
                item_categories.superCategoryId, item_categories.categoryId,
                conditionName, countryName, COUNT(DISTINCT (bids.bidId)) AS numBids,
                COUNT(DISTINCT (auction_watches.watchId)) AS numWatches,
                MAX(bids.bidPrice) AS highestBid, MAX(bids.bidPrice)as currentPrice,
                reservePrice, startPrice,
                case when
					MAX(bids.bidPrice) > auctions.reservePrice then 1
                    else 0
				end as sold


FROM auctions
                    LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
                    LEFT OUTER JOIN auction_watches ON auction_watches.auctionId = auctions.auctionId
                    JOIN (SELECT bids.auctionID FROM bids where bids.userId = 119 GROUP BY bids.auctionId ) bidded ON auctions.auctionId = bidded.auctionId
                    JOIN items ON items.itemId = auctions.itemId
                    JOIN users ON items.userId = users.userId
                    JOIN item_categories ON items.categoryId = item_categories.categoryId
                    JOIN super_item_categories ON  item_categories.superCategoryId = super_item_categories.superCategoryId
                    JOIN item_conditions ON items.conditionId = item_conditions.conditionId
                    JOIN countries ON users.countryId = countries.countryId

WHERE auctions.endTime < now()

GROUP BY  auctions.auctionId



                