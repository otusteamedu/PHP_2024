<?php

namespace Support\TestingData;

class TestingData
{
    public const TEST_WORD = 'test';

    public const CHECK_EMAIL_QUERY = '{"check":[{"email":"john69683@gmail.com"},{"email":"john69683@gmail.xxx"}]}';

    public const CHECK_EMAIL_RESULT = '{"checked":[{"john69683@gmail.com":true},{"john69683@gmail.xxx":false}]}';

    public const CHECK_SELECT_QUERY_POSITIVE = '{"from":"product","where":[{"attribute":"price","value":"1000","operator":">"}], "limit":3, "lazy":false}';

    public const CHECK_SELECT_QUERY_POSITIVE_RESULT = '[{"id":"500-000","title":"Вино белое Дартаньян","sku":"500-000","category":"Вино","price":"3257.00","volume":"1.00"},{"id":"500-001","title":"Портвейн Армабьен","sku":"500-001","category":"Портвейн","price":"4926.00","volume":"0.33"},{"id":"500-002","title":"Портвейн Розмарин","sku":"500-002","category":"Портвейн","price":"3844.00","volume":"0.50"}]';

    public const CHECK_SELECT_QUERY_NEGATIVE = '{"from":"product","where":[{"attribute":"price","value":"500000","operator":">"}], "limit":3, "lazy":false}';
}
