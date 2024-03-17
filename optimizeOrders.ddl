create index orders_id_screening_date_index
    on public.orders (id, screening_date);

create index orders_order_date_index
    on public.orders (order_date);