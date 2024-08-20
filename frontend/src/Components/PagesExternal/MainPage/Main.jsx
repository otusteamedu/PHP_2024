import React, {useEffect} from 'react';

import IndexPartnerSvg from 'images/index_partner.svg';
import YellowCardSvg from 'images/yellow_card.svg';
import ChatSvg from 'images/chat.svg';

import MainSectionExch from './MainSectionExch';
import MainSectionExchinfo from "./MainSectionExchinfo";


const Main = () => {

    useEffect(() => {
        document.title = 'Купить/продать USDT, BTC, ETH на Coinschest. Автоматический обмен.';
    },[]);

    return (
        <div className="container">

            <MainSectionExch />

            <MainSectionExchinfo />


            <section className="index_faq">
                <div className="i_f_block">
                    <div className="i_f_bl_item">
                        <h5>Как долго выполняется заказ?</h5>
                        <p>До 5 мин</p>
                    </div>
                    <div className="i_f_bl_item">
                        <h5>Откуда рубли поступят на карту?</h5>
                        <p>С банковской карты. QIWI не поддерживаем</p>
                    </div>
                    <div className="i_f_bl_item">
                        <h5>Для чего нужна верификация карты?</h5>
                        <p>Чтобы ей не воспользовались мошенники</p>
                    </div>
                    <div className="i_f_bl_item">
                        <h5>Как долго верифицируется карта?</h5>
                        <p>≈ 15 мин</p>
                    </div>
                </div>
            </section>

            <section className="index_partner">
                <div className="i_p_img">
                    <div className="i_p_i_block">
                        <img src={IndexPartnerSvg} alt="Partner"/>
                    </div>
                </div>
                <div className="i_p_text">
                    <div className="i_p_t_div">
                        <h4><a href="/partner/"><span>Партнерская программа</span> с
                            начислением до 50% с прибыли каждой операции приведенных пользователей ↗</a></h4>
                    </div>
                </div>
            </section>

            <section className="index_bonus">
                <div className="i_b_block">
                    <div className="i_b_bl_card">
                        <div className="i_b_bl_c_top">
                            <img src={YellowCardSvg} alt="bonus"/>
                        </div>
                        <div className="i_b_bl_c_bottom">
                            <h4><a href="/bonus/"><span>Бонусная программа</span> c
                                выплатой USDT за отзыв после заказа ↗</a></h4>
                        </div>
                    </div>
                    <div className="i_b_bl_card">
                        <div className="i_b_bl_c_chat">
                            <img src={ChatSvg} alt="chat"/>
                        </div>
                        <div className="i_b_bl_c_bottom">
                            <h4><span>Техподдержка</span> ежедневно с 10 до 20. Ответ на тикет — до часа</h4>
                        </div>
                    </div>
                </div>
            </section>

            <section className="index_warning">
                <div className="i_w_text">
                    <p>Транзакция может быть не принята, если окажется в высокой зоне риска неблагонадежности. Все
                        приходящие криптомонеты проходят AML и Due Diligence верификацию. <br/>Монеты с биржи
                        Garantex могут быть не приняты вследствие решения Минфина США от 05.04.2022</p>
                </div>
            </section>
        </div>
    );
};

export default Main;