<?php
declare(strict_types=1);

$db = null;

try {
    $db = pg_connect(
        "host=postgres dbname=".
        getenv("POSTGRES_DATABASE").
        " user=".getenv("POSTGRES_USER").
        " password=".getenv("POSTGRES_PASSWORD")
    );
} catch (Exception $exception) {
    echo $exception->getMessage();
}

$films = [
    [
        'id'=>'master_i_margarita',
        'name'=>'Мастер и Маргарита',
        'cost'=>500.00,
        'costluxe'=>700.00,
        'genre' => 'Драма, Мистика',
        'description' => 'Фильм по произведению М.А. Булгакова',
        'releaseDate' => 2019,
        'country' => 'Россия'
    ],
    [
        'id'=>'onegin',
        'name'=>'Онегин',
        'cost'=>400.00,
        'costluxe'=>600.00,
        'genre' => 'Драма',
        'description' => 'Фильм по произведению А.С. Пушкина',
        'releaseDate' => 2024,
        'country' => 'Россия'
    ],
    [
        'id'=>'duna_2',
        'name'=>'Дюна 2',
        'cost'=>450.00,
        'costluxe'=>650.00,
        'genre' => 'Приключения, фэнтези',
        'description' => 'Фильм на основе романа Дюга Фрэнка Герберта',
        'releaseDate' => 2024,
        'country' => 'США'
    ],
];

foreach ($films as $film) {
    try {
        $query = pg_insert($db,'films',$film);
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

$sessions = [
    ['id'=>'master_13', 'filmid'=>'master_i_margarita', 'timeBegin'=>'13:00:00', 'timeEnd'=>'16:00:00'],
    ['id'=>'master_17', 'filmid'=>'master_i_margarita', 'timeBegin'=>'17:00:00', 'timeEnd'=>'20:00:00'],
    ['id'=>'onegin_11', 'filmid'=>'onegin', 'timeBegin'=>'11:00:00', 'timeEnd'=>'14:00:00'],
    ['id'=>'onegin_16', 'filmid'=>'onegin', 'timeBegin'=>'16:00:00', 'timeEnd'=>'19:00:00'],
    ['id'=>'duna2_13', 'filmid'=>'duna_2', 'timeBegin'=>'13:00:00', 'timeEnd'=>'16:00:00'],
    ['id'=>'duna2_20', 'filmid'=>'duna_2', 'timeBegin'=>'20:00:00', 'timeEnd'=>'23:00:00']
];

foreach ($sessions as $session) {
    try {
        $query = pg_insert($db,'sessions',$session);

    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

$halls = [];
$luxe = 6;
for ($i = 1; $i <= 3; ++$i) {
    $hall = [];
    for ($row = 0; $row <= 10; ++$row) {
        for ($seat = 1; $seat <= 37; ++$seat) {
            if ($row == 0 && $seat > 19) break;
            if ($row == 1 && $seat > 21) break;
            if ($row == 2 && $seat > 23) break;
            if ($row >= 3) {
                if ($seat >= $luxe && $seat <= 32) {
                    if ($row == 3) {
                        if ($seat <= 20) $hall[$row][$seat] = [$seat,1,0];
                        continue;
                    }
                    if ($row == 4) {
                        if ($seat <= 22) $hall[$row][$seat] = [$seat,1,0];
                        continue;
                    }
                    if ($row == 5) {
                        if ($seat <= 24) $hall[$row][$seat] = [$seat,1,0];
                        continue;
                    }
                    if ($row == 6) {
                        if ($seat <= 25) $hall[$row][$seat] = [$seat,1,0];
                        continue;
                    }
                    if ($row == 7) {
                        if ($seat <= 27) $hall[$row][$seat] = [$seat,1,0];
                        continue;
                    }
                    if ($row == 8) {
                        if ($seat <= 28) $hall[$row][$seat] = [$seat,1,0];
                        continue;
                    }
                    if ($row == 9) {
                        if ($seat <= 30) $hall[$row][$seat] = [$seat,1,0];
                        continue;
                    }
                    if ($row == 10) {
                        if ($seat <= 32) $hall[$row][$seat] = [$seat,1,0];
                        continue;
                    }

                }
            }
            $hall[$row][$seat] = [$seat,0,0];
        }
    }
    $halls[$i] = $hall;
}


foreach ($halls as $hall=>$rows) {
    foreach ($rows as $row=>$seats) {
        foreach ($seats as $seat) {
            try {
                $query = pg_insert($db,'seats', [
                    'hall'=>$hall,
                    'row'=>$row,
                    'seat'=>$seat[0],
                    'luxe'=>$seat[1],
                    'booked'=>$seat[2]
                ]);

            } catch (Exception $exception) {
                echo $exception->getMessage();
            }
        }
    }
}

$tickets = [];

for ($id = 1; $id <= 30; ++$id) {
    $tickets[] = [
        'payerid' => 'payer_'.rand(1,15),
        'sessionid' => $sessions[rand(0,5)]['id'],
        'seatid' => rand(1,933),
        'amount' => 0
    ];
}
$payers = [];
foreach ($tickets as $ticket) {
    $luxeOrNot = pg_fetch_row(pg_query($db,"SELECT luxe FROM seats where id = {$ticket['seatid']};"));
    $luxeOrNot = $luxeOrNot[0];
    $cost = pg_query($db,"SELECT cost,costluxe FROM films where id = (SELECT filmid FROM sessions WHERE sessions.id = '{$ticket['sessionid']}');");
    $cost = pg_fetch_row($cost);
    $ticket['amount'] = $luxeOrNot == 't' ? $cost[1] : $cost[0];

    if (!in_array($ticket['payerid'],$payers)) {
        $payers[] = $ticket['payerid'];

        try {
            $query = pg_insert($db,'orders', [
                'payerid' => $ticket['payerid'],
                'ticketcount' => 1
            ]);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    try {
        $query = pg_insert($db,'tickets', [
            'payerid' => $ticket['payerid'],
            'sessionid' => $ticket['sessionid'],
            'seatid' => $ticket['seatid'],
            'amount' => $ticket['amount']
        ]);

    } catch (Exception $exception) {
        echo $exception->getMessage();
    }

    $query = pg_query($db,"UPDATE seats SET booked = true WHERE id = '{$ticket['seatid']}'");
}

foreach ($payers as $payer) {

    $ticketQuantity = pg_fetch_row(pg_query($db,"SELECT count(*) FROM tickets where payerid = '{$payer}';"));
    $ticketsSum = pg_fetch_row(pg_query($db,"SELECT sum(amount) FROM tickets where payerid = '{$payer}';"));

    $query = pg_query($db,"UPDATE orders SET 
                  ticketcount = {$ticketQuantity[0]},
                  sum = {$ticketsSum[0]},
                  createtime = CURRENT_TIMESTAMP
WHERE payerid = '{$payer}'");

}
