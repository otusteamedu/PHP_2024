do
$$
    begin
        perform public.insert_films(1000000);
    end
$$;

do
$$
    begin
        perform public.insert_users(1000000);
    end
$$;

do
$$
    begin
        perform public.insert_halls(5);
    end
$$;

do
$$
    begin
        perform public.insert_hall_rows(1, 100, 50);
    end
$$;

do
$$
    begin
        perform public.insert_hall_row_seats(1, 50);
    end
$$;

do
$$
    begin
        perform public.insert_sessions(1000000);
    end
$$;

do
$$
    begin
        perform public.insert_tickets(1000000);
    end
$$;

