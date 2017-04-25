<?php

ini_set("date.timezone", "Europe/Sofia");

$pdo = new PDO(
    'mysql:host=localhost;dbname=wizard_wars',
    'root',
    ''
);

function necklacesUpdation($pdo)
{

    $query = $pdo->query("SELECT un.id,un.level as necklaceLevel,u.level as userLevel,u.health,n.health_bonus, n.name,u.gold,u.mana,n.mana_bonus,u.id as userId,n.gold_bonus, un.time_to_update, u.id as userId, u.`level` as userLevel, r.health as raceHealth,n.lycan_health_bonus  
FROM users_necklaces un
LEFT JOIN necklaces n ON un.necklace_id = n.id
LEFT JOIN user u ON un.user_id = u.id
LEFT JOIN race r ON u.race = r.id
WHERE un.castle_id IS NULL");

    $query->execute();
    $necklacesForUpdate = $query->fetchAll(PDO::FETCH_ASSOC);

    $dateNow = date('Y-m-d H:i:s');


    foreach ($necklacesForUpdate as $necklace) {

        $updateTime = $necklace['time_to_update'];

        if (strtotime($dateNow) > strtotime($updateTime)) {

            $id = $necklace['id'];
            $level = $necklace['userLevel'];
            $minutes = "+" . $level . ' minutes';
            $newTime = date('Y-m-d H:i:s', strtotime($minutes, strtotime($dateNow)));

            $query = "UPDATE users_necklaces SET time_to_update='$newTime' WHERE id = $id";
            $stmt = $pdo->query($query);
            $result = $stmt->execute();
            $userId = $necklace['userId'];

            switch ($necklace['name']) {
                case "Healing Necklace":

                    $neHealth = intval($necklace['health']) + intval($necklace['health_bonus']) * intval($necklace['necklaceLevel']);
                    $healthPercentage = (intval($necklace['health']) / (intval($necklace['raceHealth']) * intval($necklace['userLevel'])) * 100);

                    if ($healthPercentage < 100) {
                        $neHealth = intval($necklace['health']) + intval($necklace['health_bonus']) * intval($necklace['necklaceLevel']);

                        $query = "UPDATE user SET health='$neHealth' WHERE id = '$userId'";
                        $stmt = $pdo->query($query);
                        $result = $stmt->execute();
                    }

                    break;
                case "Gold Necklace":

                    $newGold = intval($necklace['gold']) + intval($necklace['gold_bonus']) * intval($necklace['necklaceLevel']);

                    $query = "UPDATE user SET gold='$newGold' WHERE id = '$userId'";
                    $stmt = $pdo->query($query);
                    $result = $stmt->execute();
                    break;
                case "Mana Necklace":

                    $newMana = intval($necklace['mana']) + intval($necklace['mana_bonus']) * intval($necklace['necklaceLevel']);
                    $query = "UPDATE user SET mana='$newMana' WHERE id = '$userId'";
                    $stmt = $pdo->query($query);
                    $result = $stmt->execute();

                    break;
                case "Lycan Necklace":

                    $query = "SELECT * FROM lycans WHERE user_id = '$userId'";
                    $stmt = $pdo->query($query);
                    $stmt->execute();
                    $lycans = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($lycans as $lycan) {

                        $lycanConst = 60;
                        if (intval($lycan['health']) < $lycanConst * intval($lycan['level'])) {
                            $newHealth = intval($lycan['health']) + intval($necklace['lycan_health_bonus']) * intval($necklace['necklaceLevel']);
                            $lycanId = $lycan['id'];
                            $query = "UPDATE lycans SET health='$newHealth' WHERE id='$lycanId'";
                            $stmt = $pdo->query($query);
                            $stmt->execute();
                        }
                    }
                    break;
            }

            var_dump($result);
        } else {
            var_dump('waiting');
        }
    }
}

function wandUpdation($pdo)
{

    $query = "SELECT umw.user_id as userId, umw.id as userWandId, umw.`level` as wandLevel, u.gold as userGold, mw.price as wandPrice , umw.time_to_update as updateTime FROM users_magic_wands umw LEFT JOIN user u ON umw.user_id = u.id LEFT JOIN magic_wands mw ON mw.id = umw.magic_wand_id WHERE umw.status = 1";
    $dateNow = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $wandsForUpdate = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($wandsForUpdate as $wand) {

        $userWandID = $wand['userWandId'];
        $userWandLevel = $wand['wandLevel'];
        $newLevel = $userWandLevel + 1;
        $userId = $wand['userId'];
        $userGold = $wand['userGold'];
        $wandPrice = $wand['wandPrice'];
        $timeToUpdate = $wand['updateTime'];


        if (strtotime($dateNow) > strtotime($timeToUpdate)) {

            $getGold = $userGold - ($wandPrice * $userWandLevel);

            $updateMoneyQuery = "UPDATE user SET gold=$getGold WHERE id = $userId";
            $userWandQuery = "UPDATE users_magic_wands SET status=0,level=$newLevel WHERE id = $userWandID";

//        $smt = $pdo->query($updateMoneyQuery);
//        $stmt->execute();

            $smt = $pdo->prepare($userWandQuery);
            $smt->execute();
//
        } else {
            var_dump('wand update wait');
        }
    }
}


necklacesUpdation($pdo);
wandUpdation($pdo);