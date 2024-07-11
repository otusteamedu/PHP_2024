import StatusOkBlueSvg from 'images/status_ok_blue.svg';

const Partner = () => {
    
    return (
        <>
            <div className="partner_page_head">

                <div className="p_p_h_header">

                    <h2>Партнерская программа</h2>

                </div>

                <div className="p_p_h_reflink">

                    <div className="p_p_h_rl_btnlink">

                        <button className="yellow_btn" type="button"><span>Копировать</span></button>

                        <div className="p_p_h_rl_bl_link">

                            <span>'REF_LINK'</span>

                        </div>

                    </div>

                    <div className="p_p_h_rl_description">

                        <p>Поделитесь реферальной ссылкой, чтобы получать до 50% с прибыли каждой операции приведенных
                            клиентов</p>

                    </div>

                </div>

            </div>

            <div className="partner_page_statistic">

                <div className="p_p_s_withdraw">

                    <div className="p_p_s_w_leftdiv">

                        <div className="p_p_s_w_ld_amount"><span>0.000</span></div>

                        <div className="p_p_s_w_ld_description"><span>начислено USD</span></div>

                    </div>

                    <div className="p_p_s_w_rigthdiv">

                        <button className="yellow_btn" type="button"><a
                            href="#">Вывести</a></button>


                        <div className="p_p_s_w_rd_description"><span>Вывод от 10 USD</span></div>

                    </div>

                </div>

                <div className="p_p_s_operations">

                    <div className="p_p_s_op_block">

                        <span>0.00</span>

                        <p>начисление</p>

                    </div>

                    <div className="p_p_s_op_block">

                        <span>0</span>

                        <p>рефералов</p>

                    </div>

                    <div className="p_p_s_op_block">

                        <span>0</span>

                        <p>операций</p>

                    </div>

                </div>

            </div>

            <div className="partner_page_grid">

                <div className="partner_grid">
                    <div className="ps_g_row1">
                        <div className="ps_g_row1_td1"/>
                        <div className="ps_g_row1_td active_level">
                            Basic
                            <div className="ps_g_r1_td_ok">
                                <img src={StatusOkBlueSvg} alt="Current level" />
                            </div>
                        </div>
                        <div className="ps_g_row1_td">Start</div>
                        <div className="ps_g_row1_td">Middle</div>
                        <div className="ps_g_row1_td">Advanced</div>
                        <div className="ps_g_row1_td">Pro</div>
                    </div>
                    <div className="ps_g_row2">
                        <div className="ps_g_row2_td1">С операции реферала</div>
                        <div className="ps_g_row2_td active_level">
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
                        <div className="ps_g_row3_td active_level">От 0</div>
                        <div className="ps_g_row3_td">От 10000</div>
                        <div className="ps_g_row3_td">От 50000</div>
                        <div className="ps_g_row3_td">От 100000</div>
                        <div className="ps_g_row3_td">От 200000</div>
                    </div>
                </div>

            </div>

            <div className="partner_page_history">

                <div className="p_p_h_block">

                    <div className="p_p_h_bl_header">

                        <div className="p_p_h_bl_h_leftdiv">

                            <div className="p_p_h_bl_h_ld_tab tab_checked"><span>Операции</span></div>

                            <div className="p_p_h_bl_h_ld_tab"><span>Снятия</span></div>

                        </div>

                    </div>

                    <div className="p_p_h_bl_empty none">

                        <div className="p_p_h_bl_em_text"><span>Операции ваших рефералов появятся здесь</span></div>

                        <button className="yellow_btn" type="button"><span>Копировать реферальную ссылку</span></button>

                    </div>

                    <div className="p_p_h_bl_opertable">

                        <div className="p_p_h_bl_ot_header">

                            <div className="p_p_h_bl_ot_h_order"><span>Операция</span></div>

                            <div className="p_p_h_bl_ot_h_profit"><span>Начисление</span></div>

                        </div>

                        <div className="p_p_h_bl_ot_date"><span>18 дек 2022</span></div>

                        <div className="p_p_h_bl_ot_block">

                            <div className="p_p_h_bl_ot_bl_row">

                                <div className="p_p_h_bl_ot_bl_r_date"><span>15:32</span></div>

                                <div className="p_p_h_bl_ot_bl_r_order">

                                    <div className="p_p_h_bl_ot_bl_r_o_div">

                                        <span>Ripple → Bitcoin</span>

                                        <p>33.69 USD</p>

                                    </div>

                                </div>

                                <div className="p_p_h_bl_ot_bl_r_profit"><span>+0.0337 USD</span></div>

                            </div>

                            <div className="p_p_h_bl_ot_bl_row">

                                <div className="p_p_h_bl_ot_bl_r_date"><span>15:32</span></div>

                                <div className="p_p_h_bl_ot_bl_r_order">

                                    <div className="p_p_h_bl_ot_bl_r_o_div">

                                        <span>Ripple → Bitcoin</span>

                                        <p>33.69 USD</p>

                                    </div>

                                </div>

                                <div className="p_p_h_bl_ot_bl_r_profit"><span>+0.0337 USD</span></div>

                            </div>

                            <div className="p_p_h_bl_ot_bl_row">

                                <div className="p_p_h_bl_ot_bl_r_date"><span>15:32</span></div>

                                <div className="p_p_h_bl_ot_bl_r_order">

                                    <div className="p_p_h_bl_ot_bl_r_o_div">

                                        <span>Ripple → Bitcoin</span>

                                        <p>33.69 USD</p>

                                    </div>

                                </div>

                                <div className="p_p_h_bl_ot_bl_r_profit"><span>+0.0337 USD</span></div>

                            </div>

                            <div className="p_p_h_bl_ot_bl_row">

                                <div className="p_p_h_bl_ot_bl_r_date"><span>15:32</span></div>

                                <div className="p_p_h_bl_ot_bl_r_order">

                                    <div className="p_p_h_bl_ot_bl_r_o_div">

                                        <span>Ripple → Bitcoin</span>

                                        <p>33.69 USD</p>

                                    </div>

                                </div>

                                <div className="p_p_h_bl_ot_bl_r_profit"><span>+0.0337 USD</span></div>

                            </div>

                            <div className="p_p_h_bl_ot_bl_row">

                                <div className="p_p_h_bl_ot_bl_r_date"><span>15:32</span></div>

                                <div className="p_p_h_bl_ot_bl_r_order">

                                    <div className="p_p_h_bl_ot_bl_r_o_div">

                                        <span>Ripple → Bitcoin</span>

                                        <p>33.69 USD</p>

                                    </div>

                                </div>

                                <div className="p_p_h_bl_ot_bl_r_profit"><span>+0.0337 USD</span></div>

                            </div>

                        </div>

                        <div className="p_p_h_bl_ot_date"><span>18 дек 2022</span></div>

                        <div className="p_p_h_bl_ot_block">

                            <div className="p_p_h_bl_ot_bl_row">

                                <div className="p_p_h_bl_ot_bl_r_date"><span>15:32</span></div>

                                <div className="p_p_h_bl_ot_bl_r_order">

                                    <div className="p_p_h_bl_ot_bl_r_o_div">

                                        <span>Ripple → Bitcoin</span>

                                        <p>33.69 USD</p>

                                    </div>

                                </div>

                                <div className="p_p_h_bl_ot_bl_r_profit"><span>+0.0337 USD</span></div>

                            </div>

                            <div className="p_p_h_bl_ot_bl_row">

                                <div className="p_p_h_bl_ot_bl_r_date"><span>15:32</span></div>

                                <div className="p_p_h_bl_ot_bl_r_order">

                                    <div className="p_p_h_bl_ot_bl_r_o_div">

                                        <span>Ripple → Bitcoin</span>

                                        <p>33.69 USD</p>

                                    </div>

                                </div>

                                <div className="p_p_h_bl_ot_bl_r_profit"><span>+0.0337 USD</span></div>

                            </div>

                            <div className="p_p_h_bl_ot_bl_row">

                                <div className="p_p_h_bl_ot_bl_r_date"><span>15:32</span></div>

                                <div className="p_p_h_bl_ot_bl_r_order">

                                    <div className="p_p_h_bl_ot_bl_r_o_div">

                                        <span>Ripple → Bitcoin</span>

                                        <p>33.69 USD</p>

                                    </div>

                                </div>

                                <div className="p_p_h_bl_ot_bl_r_profit"><span>+0.0337 USD</span></div>

                            </div>

                        </div>

                    </div>

                    <div className="p_p_h_bl_empty none">

                        <div className="p_p_h_bl_em_text">
                            <span>У вас еще не было вывода партнерского вознаграждения</span></div>

                    </div>

                    <div className="p_p_h_bl_withdtable none"/>


                </div>

            </div>
        </>
    )
    
}

export default Partner;