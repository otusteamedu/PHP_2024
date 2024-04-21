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

$sessions = [
    ['id'=>'master_13', 'film_id'=>'master_i_margarita', 'timebegin'=>'13:00:00', 'timeend'=>'16:00:00'],
    ['id'=>'master_17', 'film_id'=>'master_i_margarita', 'timebegin'=>'17:00:00', 'timeend'=>'20:00:00'],
    ['id'=>'onegin_11', 'film_id'=>'onegin', 'timebegin'=>'11:00:00', 'timeend'=>'14:00:00'],
    ['id'=>'onegin_16', 'film_id'=>'onegin', 'timebegin'=>'16:00:00', 'timeend'=>'19:00:00'],
    ['id'=>'duna2_13', 'film_id'=>'duna_2', 'timebegin'=>'13:00:00', 'timeend'=>'16:00:00'],
    ['id'=>'duna2_20', 'film_id'=>'duna_2', 'timebegin'=>'20:00:00', 'timeend'=>'23:00:00'],
    ['id'=>'gents_13_20', 'film_id'=>'gents', 'timebegin'=>'13:20:00', 'timeend'=>'17:00:00'],
    ['id'=>'gents_19_45', 'film_id'=>'gents', 'timebegin'=>'19:45:00', 'timeend'=>'23:25:00'],
    ['id'=>'last_samurai_15', 'film_id'=>'last_samurai', 'timebegin'=>'15:00:00', 'timeend'=>'18:00:00'],
    ['id'=>'last_samurai_22', 'film_id'=>'last_samurai', 'timebegin'=>'22:00:00', 'timeend'=>'01:00:00']
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
                    'luxe'=>$seat[1]
                ]);

            } catch (Exception $exception) {
                echo $exception->getMessage();
            }
        }
    }
}

$tickets = [];

for ($id = 1; $id <= 300; ++$id) {
    $tickets[] = [
        'payer_id' => 'payer_'.rand(1,100),
        'session_id' => $sessions[rand(0,9)]['id'],
        'seat_id' => rand(1,933),
        'amount' => 0,
        'date' => date("Y-m-d",time() - rand(0,1000000)),
    ];
}
$payers = [];
foreach ($tickets as $ticket) {
    $luxeOrNot = pg_fetch_row(pg_query($db,"SELECT luxe FROM seats where id = {$ticket['seat_id']};"));
    $luxeOrNot = $luxeOrNot[0];
    $cost = pg_query($db,"SELECT value_float FROM values where 
                                     film_id = (SELECT film_id FROM sessions WHERE sessions.id = '{$ticket['session_id']}')
                                     AND attribute_id = 'seat_price'
;");
    $cost = pg_fetch_row($cost);
    $cost_luxe = pg_query($db,"SELECT value_float FROM values where 
                                     film_id = (SELECT film_id FROM sessions WHERE sessions.id = '{$ticket['session_id']}')
                                     AND attribute_id = 'seat_price_luxe'
;");
    $cost_luxe = pg_fetch_row($cost_luxe);
    $ticket['amount'] = $luxeOrNot == 't' ? $cost_luxe[0] : $cost[0];

    if (!in_array($ticket['payer_id'],$payers)) {
        $payers[] = $ticket['payer_id'];

        try {
            $query = pg_insert($db,'orders', [
                'payer' => $ticket['payer_id'],
                'ticketcount' => 1
            ]);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    try {
        $query = pg_insert($db,'tickets', [
            'payer_id' => $ticket['payer_id'],
            'session_id' => $ticket['session_id'],
            'seat_id' => $ticket['seat_id'],
            'amount' => $ticket['amount'],
            'date' => $ticket['date']
        ]);

    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

foreach ($payers as $payer) {

    $ticketQuantity = pg_fetch_row(pg_query($db,"SELECT count(*) FROM tickets where payer_id = '{$payer}';"));
    $ticketsSum = pg_fetch_row(pg_query($db,"SELECT sum(amount) FROM tickets where payer_id = '{$payer}';"));

    $query = pg_query($db,"UPDATE orders SET 
                  ticketcount = {$ticketQuantity[0]},
                  sum = {$ticketsSum[0]},
                  createtime = CURRENT_TIMESTAMP
            WHERE payer = '{$payer}'");

}
