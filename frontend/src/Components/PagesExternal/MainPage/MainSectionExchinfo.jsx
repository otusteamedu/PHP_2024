import React from "react";
import TriangleRightSvg from 'images/triangle_right.svg';
import FourDotSvg from 'images/4dot.svg';
import BigRightArrowSvg from 'images/big_right_arrow.svg';

const MainSectionExchinfo = () => {

    const [tabLastOpers, setTabLastOpers] = React.useState('');
    const [tabFavors, setTabFavors] = React.useState('none');
    const [historyItem, setHistoryItem] = React.useState(false);
    const [favorItem, setFavorItem] = React.useState(false);

    React.useEffect(() => {
        if (!tabLastOpers && tabFavors) {
            document.getElementById('tabFavors').addEventListener('click',() => {
                setTabLastOpers('none');
                setTabFavors('');
            })
        }

        if (tabLastOpers && !tabFavors) {
            document.getElementById('tabLastOpers').addEventListener('click',() => {
                setTabLastOpers('');
                setTabFavors('none');
            })
        }

    }, [ tabLastOpers,tabFavors ])



    return (
        <section className="index_exchinfo">

            {/*<div className="i_ex_prrates">*/}
            {/*    <div className="i_ex_pr_label">*/}
            {/*        <div className="i_ex_pr_l_div">*/}
            {/*            <div className="i_ex_pr_l_d_div">*/}
            {/*                <h4>Выгодные курсы</h4>*/}
            {/*            </div>*/}
            {/*        </div>*/}
            {/*    </div>*/}
            {/*    <div className="i_ex_pr_block_log_in">*/}
            {/*        <div className="i_ex_pr_b_item">*/}
            {/*            <div className="i_ex_pr_b_i_top">*/}
            {/*                <p className="plus">+ 162.88 RUB (1.7%)</p>*/}
            {/*            </div>*/}
            {/*            <div className="i_ex_pr_b_i_middle">*/}

            {/*                <img src='images/logo_sberrub.svg' alt="Сбербанк"/>*/}

            {/*                <p>1 BTC</p>*/}
            {/*                <img className="i_ex_f_els_b_u_select_arrow" src='images/arrow_right.svg' alt="Select arrow"/>*/}

            {/*                <img src='images/logo_sberrub.svg' alt="Сбербанк"/>*/}

            {/*                <h5>1970092.88</h5>*/}
            {/*                <p>RUB</p>*/}
            {/*            </div>*/}
            {/*        </div>*/}
            {/*        <div className="i_ex_pr_b_item">*/}
            {/*            <div className="i_ex_pr_b_i_top">*/}
            {/*                <p className="minus">- 162.88 RUB (1.7%)</p>*/}
            {/*            </div>*/}
            {/*            <div className="i_ex_pr_b_i_middle">*/}

            {/*                <img src='images/logo_sberrub.svg' alt="Сбербанк"/>*/}

            {/*                <p>1 USDT</p>*/}
            {/*                <img className="i_ex_f_els_b_u_select_arrow" src='images/arrow_right.svg' alt="Arrow right"/>*/}

            {/*                <img src='images/logo_sberrub.svg' alt="Сбербанк"/>*/}

            {/*                <h5>75.08</h5>*/}
            {/*                <p>RUB</p>*/}
            {/*            </div>*/}
            {/*        </div>*/}
            {/*        <div className="i_ex_pr_b_item">*/}
            {/*            <div className="i_ex_pr_b_i_top">*/}
            {/*                <p className="plus">+ 162.88 RUB (1.7%)</p>*/}
            {/*            </div>*/}
            {/*            <div className="i_ex_pr_b_i_middle">*/}

            {/*                <img src='images/logo_sberrub.svg' alt="Сбербанк"/>*/}

            {/*                <p>1 ETH</p>*/}
            {/*                <img className="i_ex_f_els_b_u_select_arrow" src='images/arrow_right.svg' alt="Arrow right"/>*/}

            {/*                <img src='images/logo_sberrub.svg' alt="Сбербанк"/>*/}

            {/*                <h5>136792.88</h5>*/}
            {/*                <p>RUB</p>*/}
            {/*            </div>*/}
            {/*        </div>*/}
            {/*    </div>*/}
            {/*</div>*/}

            <div className="i_ex_historyfavor_tabs">
                <div className="i_ex_hf_tabs_head">
                    <div className="i_ex_hf_l_links">
                        <h4 id="tabLastOpers" className={!tabLastOpers ? "active_tab" : ""} data-tab="tab1">Последние операции</h4>
                        <h4 id="tabFavors" className={!tabFavors ? "active_tab" : ""} data-tab="tab2">Шаблоны</h4>
                    </div>
                    <a href="/sign/" className="i_ex_hf_l_all">
                        <p>Все</p>
                        <div className="i_ex_hf_l_a_img">
                            <img src={TriangleRightSvg} alt="Triangle right"/>
                        </div>
                    </a>
                </div>

                <div className="i_ex_hf_tabs">

                    <div id="tab1" className={tabLastOpers}>
                        {
                            historyItem ? (
                                <div className="tab_block">

                                    <div className="tab_bl_r_item">
                                        <div className="tab_bl_r_i_frame">
                                            <div className="tab_bl_r_i_f_element">
                                                <p>700</p>
                                                <div className="tab_bl_r_i_f_el_cur">
                                                    <img src={FourDotSvg} alt="Four dot"/>
                                                    <p>2447</p>

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>RUB</p>
                                                </div>
                                            </div>
                                            <div className="tab_bl_r_i_f_arrow">
                                                <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                            </div>
                                            <div className="tab_bl_r_i_f_element">
                                                <p>10.26</p>
                                                <div className="tab_bl_r_i_f_el_cur">

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>USDT TRC20</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                    </div>

                                    <div className="tab_bl_r_item">
                                        <div className="tab_bl_r_i_frame">
                                            <div className="tab_bl_r_i_f_element">
                                                <p>700</p>
                                                <div className="tab_bl_r_i_f_el_cur">
                                                    <img src={FourDotSvg} alt="Four dot"/>
                                                    <p>2447</p>

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>RUB</p>
                                                </div>
                                            </div>
                                            <div className="tab_bl_r_i_f_arrow">
                                                <img src={BigRightArrowSvg} alt="Big right arrow"/>
                                            </div>
                                            <div className="tab_bl_r_i_f_element">
                                                <p>10.26</p>
                                                <div className="tab_bl_r_i_f_el_cur">

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>USDT TRC20</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                    </div>

                                    <div className="tab_bl_r_item">
                                        <div className="tab_bl_r_i_frame">
                                            <div className="tab_bl_r_i_f_element">
                                                <p>700</p>
                                                <div className="tab_bl_r_i_f_el_cur">
                                                    <img src='images/4dot.svg' alt="Four dot"/>
                                                    <p>2447</p>

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>RUB</p>
                                                </div>
                                            </div>
                                            <div className="tab_bl_r_i_f_arrow">
                                                <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                            </div>
                                            <div className="tab_bl_r_i_f_element">
                                                <p>10.26</p>
                                                <div className="tab_bl_r_i_f_el_cur">

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>USDT TRC20</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                    </div>

                                    <div className="tab_bl_r_item">
                                        <div className="tab_bl_r_i_frame">
                                            <div className="tab_bl_r_i_f_element">
                                                <p>700</p>
                                                <div className="tab_bl_r_i_f_el_cur">
                                                    <img src='images/4dot.svg' alt="Four dot"/>
                                                    <p>2447</p>

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>RUB</p>
                                                </div>
                                            </div>
                                            <div className="tab_bl_r_i_f_arrow">
                                                <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                            </div>
                                            <div className="tab_bl_r_i_f_element">
                                                <p>10.26</p>
                                                <div className="tab_bl_r_i_f_el_cur">

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>USDT TRC20</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                    </div>

                                    <div className="tab_bl_r_item">
                                        <div className="tab_bl_r_i_frame">
                                            <div className="tab_bl_r_i_f_element">
                                                <p>700</p>
                                                <div className="tab_bl_r_i_f_el_cur">
                                                    <img src='images/4dot.svg' alt="Four dot"/>
                                                    <p>2447</p>

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>RUB</p>
                                                </div>
                                            </div>
                                            <div className="tab_bl_r_i_f_arrow">
                                                <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                            </div>
                                            <div className="tab_bl_r_i_f_element">
                                                <p>10.26</p>
                                                <div className="tab_bl_r_i_f_el_cur">

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>USDT TRC20</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                    </div>

                                    <div className="tab_bl_r_item">
                                        <div className="tab_bl_r_i_frame">
                                            <div className="tab_bl_r_i_f_element">
                                                <p>700</p>
                                                <div className="tab_bl_r_i_f_el_cur">
                                                    <img src='images/4dot.svg' alt="Four dot"/>
                                                    <p>2447</p>

                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>RUB</p>
                                                </div>
                                            </div>
                                            <div className="tab_bl_r_i_f_arrow">
                                                <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                            </div>
                                            <div className="tab_bl_r_i_f_element">
                                                <p>10.26</p>
                                                <div className="tab_bl_r_i_f_el_cur">
                                                    <img src='images/logo_sberrub.svg'
                                                         alt="Сбербанк"/>

                                                    <p>USDT TRC20</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                    </div>

                                </div>
                            ) : (
                                <div className="tab_block_nouser">
                                    <h4 className="t_b_nouser">Последние операции появятся здесь, чтобы вы могли быстро повторить их</h4>
                                </div>
                            )
                        }
                    </div>

                    <div id="tab2" className={tabFavors}>
                        {
                            favorItem ? (
                                <div className="tab_block">
                                    <div className="tab_bl_row">
                                        <div className="tab_bl_r_item">
                                            <div className="tab_bl_r_i_frame">
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>700</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/4dot.svg' alt="Four dot"/>
                                                        <p>2447</p>
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>RUB</p>
                                                    </div>
                                                </div>
                                                <div className="tab_bl_r_i_f_arrow">
                                                    <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                                </div>
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>10.26</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/logo_sberrub.svg' alt="Сбербанк"/>

                                                        <p>USDT TRC20</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                        </div>
                                        <div className="tab_bl_r_item">
                                            <div className="tab_bl_r_i_frame">
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>700</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/4dot.svg' alt="Four dot"/>
                                                        <p>2447</p>
                                                        <img src='images/logo_sberrub.svg' alt="Сбербанк"/>

                                                        <p>RUB</p>
                                                    </div>
                                                </div>
                                                <div className="tab_bl_r_i_f_arrow">
                                                    <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                                </div>
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>10.26</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>USDT TRC20</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                        </div>
                                    </div>
                                    <div className="tab_bl_row">
                                        <div className="tab_bl_r_item">
                                            <div className="tab_bl_r_i_frame">
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>700</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/4dot.svg' alt="Four dot"/>
                                                        <p>2447</p>
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>RUB</p>
                                                    </div>
                                                </div>
                                                <div className="tab_bl_r_i_f_arrow">
                                                    <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                                </div>
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>10.26</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>USDT TRC20</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                        </div>
                                        <div className="tab_bl_r_item">
                                            <div className="tab_bl_r_i_frame">
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>700</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/4dot.svg' alt="Four dot"/>
                                                        <p>2447</p>
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>RUB</p>
                                                    </div>
                                                </div>
                                                <div className="tab_bl_r_i_f_arrow">
                                                    <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                                </div>
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>10.26</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>USDT TRC20</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                        </div>
                                    </div>
                                    <div className="tab_bl_row">
                                        <div className="tab_bl_r_item">
                                            <div className="tab_bl_r_i_frame">
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>700</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/4dot.svg' alt="Four dot"/>
                                                        <p>2447</p>
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>RUB</p>
                                                    </div>
                                                </div>
                                                <div className="tab_bl_r_i_f_arrow">
                                                    <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                                </div>
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>10.26</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>USDT TRC20</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                        </div>
                                        <div className="tab_bl_r_item">
                                            <div className="tab_bl_r_i_frame">
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>700</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/4dot.svg' alt="Four dot"/>
                                                        <p>2447</p>
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>RUB</p>
                                                    </div>
                                                </div>
                                                <div className="tab_bl_r_i_f_arrow">
                                                    <img src='images/big_right_arrow.svg' alt="Big right arrow"/>
                                                </div>
                                                <div className="tab_bl_r_i_f_element">
                                                    <p>10.26</p>
                                                    <div className="tab_bl_r_i_f_el_cur">
                                                        <img src='images/logo_sberrub.svg'
                                                             alt="Сбербанк"/>

                                                        <p>USDT TRC20</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>0x779675027A41B7046259bB3F24Cb49d60d40ffb2</p>
                                        </div>
                                    </div>
                                </div>
                            ) : (
                                <div className="tab_block_nouser">
                                    <h4 className="t_b_nouser">Шаблонов нет</h4>
                                </div>
                            )
                        }
                    </div>
                </div>

            </div>
        </section>
    )
}

export default MainSectionExchinfo;