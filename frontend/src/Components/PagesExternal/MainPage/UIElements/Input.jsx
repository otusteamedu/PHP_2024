import useOutsideClickFrom from '../../../customHooks/useOutsideClickFrom';
import useOutsideClickTo from '../../../customHooks/useOutsideClickTo';
import React from 'react';

import SelectArrowSvg from 'images/select_arrow.svg';
import RevertSvg from 'images/revert.svg';
import {Field} from "formik";


const Input = ({
                   selectFrom,          // Валюты селекта From
                   selectTo,            // Валюты селекта To
                   currencyFrom,        // Выбранная валюта From
                   factorFrom,          // Число, округление у выбр. валюты From
                   currencyTo,          // Выбранная валюта To
                   factorTo,            // Число, округление у выбр. валюты To
                   titles,              // Названия валют
                   chooseFrom,          // Функция выбора валюты From
                   chooseTo,            // Функция выбора валюты To
                   sumFromMin,          // Мин. сумма валюты From
                   sumFromMax,          // Макс. сумма валюты From
                   sumToMax,            // Макс. сумма валюты To
                   onClick,             // Функция клика по инпуту
                   rate,                // Курс обмена
                   isFiat               // Округление фиата
}) => {

    const { refFrom, openFrom, setOpenFrom } = useOutsideClickFrom(false);
    const { refTo, openTo, setOpenTo } = useOutsideClickTo(false);
    const [inputValueFrom, setInputValueFrom] = React.useState('');
    const [inputValueTo, setInputValueTo] = React.useState('');
    const [focusInputFrom, setFocusInputFrom] = React.useState(false);
    const [focusInputTo, setFocusInputTo] = React.useState(false);

    //let curNames = titles? JSON.parse(titles) : [];
    //console.log(titles);
    let curNames = titles? titles : [];

    React.useEffect(() => {
        if ((inputValueFrom - (0.0001 * inputValueFrom)) > sumFromMax) changeInputSum(sumFromMax, 'fs');
    }, [ inputValueFrom ])

    React.useEffect(() => {
        setFocusInputFrom(false);
        setFocusInputTo(false);
    }, [ currencyFrom, currencyTo ])

    React.useEffect(() => {
        if (!focusInputFrom && !focusInputTo) changeInputSum(sumFromMin, 'fs');
    }, [ sumFromMin ]);

    function round100(val) {
        return Math.round(val / 100) * 100;
    }

    const changeInputSum = (value, target) => {
        if (target === 'fs') {
            setInputValueFrom(value);
            setInputValueTo(Number(value * (1 / rate)).toFixed(factorTo));
            //console.log('Показываем TO : ' + value + ' * ' + rate);
        }
        if (target === 'ts') {
            setInputValueTo(value);
            setInputValueFrom(Number(value * (rate)).toFixed(factorFrom));
        }
    }

    const blurRoundFrom = (value) => {
        if (isFiat && isFiat === 'fs') {
            setInputValueFrom(round100(value));
            setInputValueTo(Number(round100(value) * rate).toFixed(factorTo));
        }
    }

    const blurRoundTo = (value) => {
        if (isFiat && isFiat === 'ts') {
            setInputValueTo(round100(value));
            setInputValueFrom(Number(inputValueTo * (1 / rate)).toFixed(factorFrom));
        }
        // if (isFiat && isFiat === 'fs') {
        //     setInputValueFrom(round100(Number(inputValueTo * (1 / rate)).toFixed(factorFrom)));
        // }
    }

    return (
        <>
            <div className="i_ex_f_els_block">
                <div className="i_ex_f_els_b_above">
                    <div className="i_ex_f_els_b_u_minmax">Макс. сумма {sumFromMax}</div>
                </div>

                <div className="i_ex_f_els_b_input">
                    <div className="i_ex_f_els_b_inp_input">
                        <label hidden htmlFor='fs'>Получаете</label>
                        <Field
                            type='text'
                            autoComplete="off"
                            onKeyPress={(e) => !/[0-9.]/.test(e.key) && e.preventDefault()}
                            className = ""
                            name = 'fs'
                            id = 'fs'
                            value = {inputValueFrom || 0}
                            onChange = {(e) => changeInputSum(e.target.value, e.target.id)}
                            onClick = {onClick}
                            onBlur={(e) => blurRoundFrom(e.target.value)}
                            onFocus={() => setFocusInputFrom(true)}
                        />
                    </div>
                    <div className="i_ex_f_els_b_inp_crypto"></div>
                </div>

                <div className="i_ex_f_els_b_under">
                    <div className="i_ex_f_els_b_u_minmax">от {sumFromMin}</div>
                    <div
                        id = 'tmp-fc'
                        className = "i_ex_f_els_b_u_select"
                        onClick = {() => setOpenFrom(!openFrom)}
                        ref={refFrom}
                    >

                        <img src = {currencyFrom ? `images/logo_${currencyFrom}.svg` : ''} alt = {curNames[currencyFrom]}/>
                        <p className="i_ex_f_els_b_u_select_coin">{
                            curNames[currencyFrom]
                        }</p>
                        <img src={SelectArrowSvg} alt="Select arrow"/>
                    </div>
                </div>

                <div className={`i_ex_f_els_b_u_div ${openFrom ?  '' : 'none'}`}>
                    <div id = 'select_fc'>

                        {/*<div className="i_ex_f_els_b_sd_search">*/}
                        {/*    <img className="i_ex_f_els_b_sd_s_icon" src='images/search_icon.svg' alt="Search icon"/>*/}
                        {/*    <input type="text" className="search" placeholder="Поиск"/>*/}
                        {/*</div>*/}

                        {
                            selectFrom?.map((code) => (
                                <div
                                    key={code}
                                    className="i_ex_f_els_b_sd_option"
                                    onClick={chooseFrom}
                                    id = {code}
                                >
                                    <div id = {code} className="i_ex_f_els_b_sd_o_cur">

                                         <img src={code ? `images/logo_${code}.svg` : ''}
                                              alt={curNames[code]}
                                              id={code}
                                        />

                                        <p id = {code}>
                                            {curNames[code]}
                                        </p>
                                    </div>
                                    {/*<p id = {code}>1 = 43 238 RUB</p>*/}
                                </div>
                            ))
                        }
                    </div>
                </div>
            </div>

            <div className="i_ex_f_elems_revert">
                <img src={RevertSvg} alt="Revert"/>
            </div>

            <div className="i_ex_f_els_block">

                <div className="i_ex_f_els_b_input">
                    <div className="i_ex_f_els_b_inp_input">
                        <label hidden htmlFor='ts'>Получаете</label>
                        <input
                            type='text'
                            autoComplete="off"
                            onKeyPress={(e) => !/[0-9.]/.test(e.key) && e.preventDefault()}
                            className = ""
                            name = 'ts'
                            id = 'ts'
                            value = {inputValueTo || 0}
                            onChange = {(e) => changeInputSum(e.target.value, e.target.id)}
                            onClick = {onClick}
                            onBlur={(e) => blurRoundTo(e.target.value)}
                            onFocus={() => setFocusInputTo(true)}
                        />
                    </div>
                    <div className="i_ex_f_els_b_inp_crypto"></div>
                </div>

                <div className="i_ex_f_els_b_under">
                    <div className="i_ex_f_els_b_u_minmax">до {sumToMax}</div>
                    <div
                        id = 'tmp-tc'
                        className = "i_ex_f_els_b_u_select"
                        onClick = {() => setOpenTo(!openTo)}
                        ref={refTo}
                    >
                        <img src = {currencyTo ? `images/logo_${currencyTo}.svg` : ''} alt = {curNames[currencyTo]}/>
                        <p className="i_ex_f_els_b_u_select_coin">{
                            curNames[currencyTo]
                        }</p>
                        <img src={SelectArrowSvg} alt="Select arrow"/>
                    </div>
                </div>

                <div className={`i_ex_f_els_b_u_div ${openTo ?  '' : 'none'}`}>
                    <div id = 'select_tc'>

                        {/*<div className="i_ex_f_els_b_sd_search">*/}
                        {/*    <img className="i_ex_f_els_b_sd_s_icon" src='images/search_icon.svg' alt="Search icon"/>*/}
                        {/*    <input type="text" className="search" placeholder="Поиск"/>*/}
                        {/*</div>*/}

                        {
                            selectTo?.map((code) => (
                                <div
                                    key={code}
                                    className="i_ex_f_els_b_sd_option"
                                    onClick={chooseTo}
                                    id = {code}
                                >
                                    <div id = {code} className="i_ex_f_els_b_sd_o_cur">

                                        <img src={`images/logo_${code}.svg`}
                                             alt = {curNames[code]}
                                             id = {code}
                                        />

                                        <p id = {code}>
                                            {curNames[code]}
                                        </p>
                                    </div>
                                    {/*<p id = {code}>1 = 43 238 RUB</p>*/}
                                </div>
                            ))
                        }
                    </div>
                </div>
            </div>
        </>
    );
};

export default Input;