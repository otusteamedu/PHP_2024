##  Самые большие объекты

| object_name                                  | object_type | total_size | size_bytes |
|----------------------------------------------|-------------|------------|------------|
| ticket                                       | table       | 1175 MB    | 1232560128 |
| ticket_session_id_price_discount_percent_idx | index       | 271 MB     | 283869184  |
| ticket_unique                                | index       | 194 MB     | 203563008  |
| ticket_pkey                                  | index       | 169 MB     | 177152000  |
| ticket_session_id_idx                        | index       | 48 MB      | 50266112   |
| ticket_seat_id_idx                           | index       | 46 MB      | 48750592   |
| ticket_is_sold_idx                           | index       | 46 MB      | 48390144   |
| price                                        | table       | 7152 kB    | 7323648    |
| session                                      | table       | 3688 kB    | 3776512    |
| session_seat_unique                          | index       | 1328 kB    | 1359872    |
| price_pkey                                   | index       | 1328 kB    | 1359872    |
| session_hall_id_tstzrange_excl               | index       | 1232 kB    | 1261568    |
| price_session_id_idx                         | index       | 976 kB     | 999424     |
| session_start_idx                            | index       | 456 kB     | 466944     |
| session_pkey                                 | index       | 456 kB     | 466944     |


## Самые популярные индексы

| index_name                     | table_name | usage_count |
|--------------------------------|------------|-------------|
| ticket_unique                  | ticket     | 10954096    |
| session_seat_unique            | price      | 4764439     |
| seat_pkey                      | seat       | 4704456     |
| session_hall_id_tstzrange_excl | session    | 40002       |
| ticket_pkey                    | ticket     | 94          |

## Самые редко используемые индексы

| index_name             | table_name | usage_count |
|------------------------|------------|-------------|
| hall_pkey              | hall       | 0           |
| name                   | hall       | 0           |
| seat_type_pkey         | seat_type  | 0           |
| session_hall_id_idx    | session    | 0           |
| price_seat_type_id_idx | price      | 0           |