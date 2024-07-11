import StatusOkSvg from 'images/status_ok.svg';

const VerifyCard = () => {
    
    return (
        <>
            <div className="card_page_head">

                <div className="card_page_head_title">
                    <h2>Банковские карты</h2>
                </div>

                <div className="p_h_card_verify">

                    <div className="g_h_c_ver_row">

                        <div className="credit_card">

                            <div className="cr_c_number">•••• 3445</div>


                            <div className="cr_c_bank">
                                <img src="/images/logo_cardrub.svg" alt="card logo" />
                            </div>
                            
                            <div className="cr_c_div">
                                <img className="cr_c_div_status" src={StatusOkSvg} alt="card_status" />
                            </div>


                        </div>

                        <div className="credit_card">

                            <div className="cr_c_number">•••• 3445</div>


                            <div className="cr_c_bank">
                                <img className="" src="/images/logo_cardrub.svg" alt="sber logo" />
                            </div>


                            <div className="cr_c_div">
                                <img className="cr_c_div_status" src={StatusOkSvg} alt="card_status" />
                            </div>


                        </div>

                        <div className="credit_card">

                            <div className="cr_c_number">•••• 3445</div>


                            <div className="cr_c_bank">
                                <img className="" src="/images/logo_cardrub.svg" alt="sber logo" />
                            </div>


                            <div className="cr_c_div">
                                <img className="cr_c_div_status" src={StatusOkSvg} alt="card_status" />
                            </div>


                        </div>

                        <div className="credit_card">

                            <div className="cr_c_number">•••• 3445</div>


                            <div className="cr_c_bank">
                                <img className="" src="/images/logo_cardrub.svg" alt="sber logo" />
                            </div>


                            <div className="cr_c_div">
                                <img className="cr_c_div_status" src={StatusOkSvg} alt="card_status" />
                            </div>


                        </div>

                        <div className="credit_card">

                            <div className="cr_c_number">•••• 3445</div>


                            <div className="cr_c_bank">
                                <img className="" src="/images/logo_cardrub.svg" alt="sber logo" />
                            </div>


                            <div className="cr_c_div">
                                <img className="cr_c_div_status" src={StatusOkSvg} alt="card_status" />
                            </div>


                        </div>

                    </div>

                </div>

            </div>

            <div className="card_page_body">

                <div className="c_p_b_title_steps">

                    <h3>Верификация карты</h3>

                    <div className="c_p_b_ts_steps">

                        <div className="c_p_b_st_1"><p>1</p></div>

                        <div className="c_p_b_st_between">

                            <div className="c_p_b_st_bn_line"/>

                        </div>

                        <div className="c_p_b_st_2"><p>2</p></div>

                    </div>

                </div>

                <div className="c_p_b_step1 none">

                    <div className="c_p_b_step1_div">

                        <input type="text" className="c_p_b_en_input" aria-label="Card verify"
                               placeholder="Номер карты" />

                            <div className="c_p_en_accept">
                                <p>Поддерживаем:</p>

                            </div>

                    </div>

                </div>

                <div className="c_p_b_step2">

                    <div className="c_p_b_s2_cardlabel">

                        <div className="c_p_b_s2_cl_div">

                            <div className="c_p_b_s2_cl_d_label"><p>Карта</p></div>

                            <div className="c_p_b_s2_cl_d_card">

                                <div className="c_p_b_s2_cl_d_c_number">•••• 3456</div>

                                <img className="" src="/images/logo_cardrub.svg" alt="sber logo" />

                            </div>

                        </div>

                    </div>

                    <div className="c_p_b_s2_cardtype">

                        <div className="c_p_b_s2_ct_div">

                            <input type="radio" name="step2_cardtype" id="step2_plastic" checked />
                                <label htmlFor="step2_plastic">Пластиковая карта</label>

                        </div>
                        <div className="c_p_b_s2_ct_div">

                            <input type="radio" name="step2_cardtype" id="step2_digital" />
                                <label htmlFor="step2_digital">Цифровая карта</label>

                        </div>

                    </div>

                    <div className="c_p_b_s2_name">

                        <div className="c_p_b_s2_n_label"><p>Введите Ваши фамилию и имя</p></div>

                        <div className="c_p_b_s2_n_block">

                            <input aria-label="Surname" type="text" className="c_p_b_s2_n_bl_input"
                                   placeholder="Фамилия" />

                                <div className="c_p_b_s2_n_bl_wraper">
                                    <div className="c_p_b_s2_n_bl_line"/>
                                </div>

                                <input aria-label="Name" type="text" className="c_p_b_s2_n_bl_input" placeholder="Имя" />
                            <div className="c_p_b_s2_n_bl_wraper">
                                <div className="c_p_b_s2_n_bl_line"/>
                            </div>

                            <input aria-label="MiddleName" type="text" className="c_p_b_s2_n_bl_input" placeholder="Отчество" />

                        </div>

                    </div>

                    <div className="c_p_b_s2_download">

                        <div className="c_p_b_s2_dl_box">

                            <div className="c_p_b_s2_dl_b_choose">

                                <p>Фото карты на фоне страницы сервиса</p>

                                <span>Выбрать</span>

                            </div>

                            <div className="c_p_b_s2_dl_b_footer">

                                <p>jpg jpeg png bmp</p>
                                <p>•</p>
                                <p>от 100 КБ до 8 МБ</p>

                            </div>

                        </div>

                    </div>

                    <div className="c_p_b_s2_sample">

                        <div className="c_p_b_s2_s_text">

                            <p>На фото должны быть отчетливо видны 6 первых и 4 последних цифры номера карты, срок
                                действия и ID.</p>

                            <p>Чтобы верификация прошла быстрее, не искажайте фотографию</p>

                        </div>

                        <div className="c_p_b_s2_s_photo">

                            <div className="c_p_b_s2_s_ph_text">
                                <p>Образец</p>
                            </div>

                        </div>

                    </div>

                    <div className="c_p_b_s2_submit">

                        <button type="submit" className="c_p_b_s2_sub_btn yellow_btn">Отправить</button>

                    </div>

                </div>


            </div>
        </>
    )
    
}

export default VerifyCard;