<?php
// Function to roll items for all ranks
function rollItemsForAllRanks($vipRank, $itemTierRarity) {
    // Roll items and track distribution
    $itemDistribution = [];
    foreach ($vipRank as $rank) {
        $itemDistribution[$rank] = array_fill_keys(array_map('strval', $itemTierRarity), 0);
    }

    for ($i = 0; $i < 100; $i++) {
        foreach ($vipRank as $rank) {
            list($vip, $tier) = rollItem($rank, $vipRank, $itemTierRarity);
            $itemDistribution[$rank][strval($tier)]++;
        }
    }

    // Generate HTML output
    $output = "<h2>Item Distribution Results:</h2>";
    foreach ($itemDistribution as $rank => $distribution) {
        $output .= "<p>$rank: ";
        foreach ($distribution as $tier => $count) {
            $output .= "Tier $tier - $count, ";
        }
        $output .= "</p>";
    }
    return $output;
}

// Function to roll an item
function rollItem($vipRank, $allVipRanks, $itemTierRarity) {
    $tierRange = array_slice($itemTierRarity, 0, array_search($vipRank, $allVipRanks) + 2); // Adjust tier range based on VIP rank
    $tier = $tierRange[array_rand($tierRange)];
    return [$vipRank, $tier];
}

// Define default item tiers and VIP ranks
$item_tier_rarity = isset($_GET['itemTiers']) ? explode(',', $_GET['itemTiers']) : [1, 2, 3, 4, 5]; // Default tiers if not provided
$vip_rank = isset($_GET['vipLevels']) ? explode(',', $_GET['vipLevels']) : ['vip1', 'vip2', 'vip3', 'vip4', 'vip5']; // Default ranks if not provided

// Call function to generate item distribution
echo rollItemsForAllRanks($vip_rank, $item_tier_rarity);
?>
