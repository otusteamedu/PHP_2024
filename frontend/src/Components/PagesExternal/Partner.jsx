import React from 'react';

const Partner = () => {
    return (
        <div className="container">

            <div className="partner_header">
                <div className="part_head_block">
                    <h2>Партнерская программа</h2>
                    <div className="p_h_b_desc">
                        <p>Поделитесь реферальной ссылкой, чтобы получать до 50% с прибыли каждой операции приведенных
                            пользователей</p>
                    </div>
                    <button className="p_h_b_btn yellow_btn">Получить ссылку</button>
                </div>
            </div>

            <div className="partner_body">
                <div className="part_body_block">
                    <div className="part_body_bl_grid">
                        <div className="partner_grid">
                            <div className="ps_g_row1">
                                <div className="ps_g_row1_td1"></div>
                                <div className="ps_g_row1_td">Basic</div>
                                <div className="ps_g_row1_td">Start</div>
                                <div className="ps_g_row1_td">Middle</div>
                                <div className="ps_g_row1_td">Advanced</div>
                                <div className="ps_g_row1_td">Pro</div>
                            </div>
                            <div className="ps_g_row2">
                                <div className="ps_g_row2_td1">С операции реферала</div>
                                <div className="ps_g_row2_td">
                                    10
                                    <div className="part_percent">%</div>
                                </div>
                                <div className="ps_g_row2_td">
                                    20
                                    <div className="part_percent">%</div>
                                </div>
                                <div className="ps_g_row2_td">
                                    30
                                    <div className="part_percent">%</div>
                                </div>
                                <div className="ps_g_row2_td">
                                    40
                                    <div className="part_percent">%</div>
                                </div>
                                <div className="ps_g_row2_td">
                                    50
                                    <div className="part_percent">%</div>
                                </div>
                            </div>
                            <div className="ps_g_row3">
                                <div className="ps_g_row3_td1">Сумма операций рефералов, USD</div>
                                <div className="ps_g_row3_td">От 0</div>
                                <div className="ps_g_row3_td">От 10000</div>
                                <div className="ps_g_row3_td">От 50000</div>
                                <div className="ps_g_row3_td">От 100000</div>
                                <div className="ps_g_row3_td">От 200000</div>
                            </div>
                        </div>
                    </div>
                    <div className="part_grid_descr">
                        <p>Чем больше сумма операций приведенных пользователей, тем больше начисление % прибыли с данных
                            операций на счет партнера.</p>
                    </div>
                </div>
            </div>

            <div className="partner_footer">
                <p>Мы имеем право отменить выплату начислений, если реферальная ссылка была использована для создания
                    новых аккаунтов на одного и того же пользователя, была связана с распространением спама, или
                    использована в мошенничестве</p>
            </div>

        </div>
    );
};

export default Partner;