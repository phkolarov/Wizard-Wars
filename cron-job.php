<?php

ini_set("date.timezone", "Europe/Sofia");

$pdo = new PDO(
    'mysql:host=localhost;dbname=wizard_wars',
    'root',
    ''
);


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

    if (strtotime($dateNow)> strtotime($updateTime)) {

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

               if($healthPercentage < 100){
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

                foreach ($lycans as $lycan){

                    $lycanConst = 60;
                    if(intval($lycan['health']) < $lycanConst * intval($lycan['level']) ){
                        $newHealth = intval($lycan['health'] )+ intval($necklace['lycan_health_bonus']) * intval($necklace['necklaceLevel']);
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


$query = "SELECT * FROM users_magic_wands";

$stmt = $pdo->query($query);
$stmt->execute();
$wandsForUpdate = $stmt->fetchAll(PDO::FETCH_ASSOC);
var_dump($wandsForUpdate);