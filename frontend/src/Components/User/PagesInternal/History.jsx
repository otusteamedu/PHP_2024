import StatusOkSvg from 'images/status_ok.svg'
import React from "react";

const History = () => {

    return (
        <>

            <div className="page_head">
                <div className="log_head_title">
                    <h2>История операций</h2>
                </div>
            </div>

            <div className="page_body">

                <div id="history_table">

                    <div className="h_t_header">
                        <div className="h_t_h_div">
                            <button type="button" className="h_t_h_div_button">На карту</button>
                            <button type="button" className="h_t_h_div_button">С карты</button>
                        </div>
                    </div>

                    <div className="h_t_tablehead">
                        <div className="h_t_th_number"><p>№</p></div>
                        <div className="h_t_th_exch"><p>Обмен</p></div>
                        <div className="h_t_th_time"><p>Время</p></div>
                        <div className="h_t_th_status"><p>Статус</p></div>
                    </div>

                    <div className="h_t_date"><p>18 дек 2022</p></div>

                    <div className="h_t_block">

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>17543</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">70000 ВТБ Банк → 10.26 USDT (BEP20)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>19543</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">700 ВТБ Банк → 10.2600 USDT (BEP20)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>1</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">700 ВТБ Банк → 10.26 USDT (BEP0920)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div className="h_t_date"><p>15 дек 2022</p></div>

                    <div className="h_t_block">

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>1</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">700 ВТБ Банк → 10.26 USDT (BEP20)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>1</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">700 ВТБ Банк → 10.26 USDT (BEP20)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>1</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">70000 ВТБ Банк → 10.26 USDT (BEP20)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div className="h_t_date"><p>15 дек 2022</p></div>

                    <div className="h_t_block">

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>1</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">700 ВТБ Банк → 10.26 USDT (BEP20)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>1</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">700 ВТБ Банк → 10.26 USDT (BEP20)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                        <div className="h_t_bl_row">
                            <div className="h_t_bl_r_number"><p>1</p></div>
                            <div className="h_t_bl_r_cur">
                                <p className="h_t_bl_r_c_direct">70000 ВТБ Банк → 10.26 USDT (BEP20)</p>
                                <p className="h_t_bl_r_c_account">0x7796750...</p>
                            </div>
                            <div className="h_t_bl_r_time"><p>15:32:06</p></div>
                            <div className="h_t_bl_r_status">
                                <div className="h_t_bl_r_s_img"><img src={StatusOkSvg} alt="Status ok"/>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div className="p_b_content none">
                    <div className="p_b_c_text">
                        <p>История операций появится на этой странице</p>
                    </div>
                    <a href="#" className="p_b_c_btn yellow_btn"><span>Обменять валюту</span></a>
                </div>

            </div>

        </>
    )

}

export default History;