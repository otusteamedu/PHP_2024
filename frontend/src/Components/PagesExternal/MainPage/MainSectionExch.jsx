import React from 'react';
import Input from "./UIElements/Input";
import PostServices from "../../Helpers/PostServices";
import {number, string} from "yup";


const MainSectionExch = () => {

    // Данные для обмена
    const [data, setData] = React.useState({});

    // Установка валют
    const [fromCurrency,setFromCurrency] = React.useState('');
    const [toCurrency,setToCurrency] = React.useState('');

    // Курс обмена
    const [fromPrice,setFromPrice] = React.useState(0);
    const [toPrice,setToPrice] = React.useState(0);

    // Установка допустимых валют для обмена
    const [fromCurs,setFromCurs] = React.useState([]);
    const [toCurs,setToCurs] = React.useState([]);

    // Названия валют
    const [getTitles, setGetTitles] = React.useState([]);

    // Курс обмена
    const [rateExch,setRateExch] = React.useState('');

    // Мин. и макс. сумма
    const [minFromSum,setMinFromSum] = React.useState(null);
    const [maxFromSum,setMaxFromSum] = React.useState(null);
    const [maxToSum,setMaxToSum] = React.useState(null);

    // Проверка на фиат для округления
    const [isFiat, setIsFiat] = React.useState(false);

    const [curInfo, setCurInfo] = React.useState();
    const time = 30;

    const getBackend = async () => {
        await PostServices.getPageData()
            .then(res => setData(res))
    }

    const dataCurs = data.currencies;
    const dataPairs = data.exchange_pairs;

    const curInfoPrepare = () => {
        let curInfoPrepare = {};
        for (let key1 in dataCurs) {
            if (dataCurs.hasOwnProperty(key1)) {
                curInfoPrepare[key1] = {};
                curInfoPrepare[key1].title = dataCurs[key1].title;
                curInfoPrepare[key1].type = dataCurs[key1].type;
                curInfoPrepare[key1].rate_to_usd = dataCurs[key1].rate_to_usd;
                curInfoPrepare[key1].balance = dataCurs[key1].balance;
                curInfoPrepare[key1].inc_min_amount = dataCurs[key1].inc_min_amount;
                curInfoPrepare[key1].inc_max_amount = dataCurs[key1].inc_max_amount;
                curInfoPrepare[key1].outc_min_amount = dataCurs[key1].outc_min_amount;
                curInfoPrepare[key1].outc_max_amount = dataCurs[key1].outc_max_amount;
            }
        }
        return curInfoPrepare;
    }

    const curNames = () => {
        let titles = [];
        for (const [coin,values] of Object.entries(curInfoPrepare())) {
            titles[coin] = values.title;
        }
        return titles;
    }

    const getRateExch = () => {

        if (!fromCurrency || !toCurrency) return;

        for (const [keyRE, valueRE] of Object.entries(dataPairs)) {
            if (keyRE !== fromCurrency) continue;
            for (const [keyTRE, valueTRE] of Object.entries(valueRE)) {
                if (valueTRE.cur_to && valueTRE.profit && valueTRE.cur_to === toCurrency) {
                    setRateExch(valueTRE.profit);
                    break;
                }
            }
        }
    }

    const defaultExchange = () => {
        // Выбираем первую пару валют для обмена
        if (!fromCurrency && !toCurrency && dataPairs) {

            for (const [keyFE, valueFE] of Object.entries(dataPairs)) {
                for (const [keyTE, valueTE] of Object.entries(valueFE)) {
                    if (valueTE.cur_to && valueTE.profit) {
                        setFromCurrency(keyFE);
                        setToCurrency(valueTE.cur_to);
                        break;
                    }
                }
            }
        }
    }

    // Доступные валюты для обмена
    const availableCurs = () => {

        if (!dataPairs) return;

        let availableCurs = {
            from: [],
            to: []
        };
        for (const [keyF,value] of Object.entries(dataPairs)) {

            if (keyF === fromCurrency) continue;

            (availableCurs.from).push(keyF);

            for (const [keyT,valueT] of Object.entries(value)) {

                if (valueT.cur_to === toCurrency || (availableCurs.to).includes(valueT.cur_to)) continue;
                (availableCurs.to).push(valueT.cur_to);
            }

        }

        return availableCurs;
    }

    const changeCurFrom = () => {
        for (const [k,arr] of Object.entries(dataPairs)) {

            if (k !== fromCurrency) continue;

            for (const [t,arrT] of Object.entries(arr)) {

                if (arrT.cur_to) {
                    setToCurrency(arrT.cur_to);
                    break;
                }
            }
            break;
        }
    }

    const changeCurTo = () => {
        if (!fromCurrency || !toCurrency) return;
        let toCurArr = [];
        for (const [o,l] of Object.entries(dataPairs)) {
            if (o !== fromCurrency) continue;
            for (const [n,m] of Object.entries(l)) {
                if (m.cur_to !== toCurrency) {
                    toCurArr.push(m.cur_to);
                }
            }
        }
        return toCurArr;
    }

    const rateRow = () => {
        if (!fromCurrency ||!toCurrency) return;
        if (curInfo[fromCurrency].rate_to_usd === curInfo[toCurrency].rate_to_usd) {
            setFromPrice(Number(curInfo[fromCurrency].rate_to_usd) * Number(rateExch));
            setToPrice(Number(curInfo[toCurrency].rate_to_usd));
        }
    }

    const setMinMax = () => {

        if (!fromCurrency || !toCurrency || !curInfoPrepare()) return;

        setMinFromSum(curInfoPrepare()[fromCurrency].inc_min_amount);
        setMaxFromSum(curInfoPrepare()[fromCurrency].inc_max_amount);
        setMaxToSum(curInfoPrepare()[toCurrency].outc_max_amount);

    }

    React.useEffect(() => {

        if (!Object.keys(data).length) {
            try {
                getBackend().then(r => {});
            } catch (e) {
                console.warn(e.message());
            }
        }

        if (!getTitles) setGetTitles(curNames());

        if (!fromCurrency && !toCurrency) {
            defaultExchange();
        }
        rateRow();
        getRateExch();
        if (!curInfo) setCurInfo(curInfoPrepare());
        setMinMax();
    });

    React.useEffect(() => {
        const interval = setInterval(() => {
            getBackend()
                .then(() => {})
                .catch((err) => console.warn(err))
        }, time * 1000);
        return () => clearInterval(interval);

    });

    React.useEffect(() => {
        if (!fromCurrency && !toCurrency) {
            defaultExchange();
        }
        setCurInfo(curInfoPrepare());
        setGetTitles(curNames());
        setMinMax();
        getRateExch();
    },[data]);

//console.log(curInfoPrepare());

    React.useEffect(() => {
        if (fromCurrency) changeCurFrom();
        setFromCurs(availableCurs()?.from);
    },[fromCurrency]);

    React.useEffect(() => {
        setToCurs(changeCurTo());
    },[toCurrency]);

    const chooseFromCurrency = (e) => {
        setFromCurrency(e.target.id);

        //setCookie('fc',e.target.id);
        // let url = '/exchanger/' + e.target.id + '-' + toCurrency + '/';
        // setPostUrl(url);
        // getPost(url).then(r => {});
    }

    const chooseToCurrency = (e) => {
        setToCurrency(e.target.id);

        // //setCookie('tc',e.target.id);
        // let url = '/exchanger/' + fromCurrency + '-' + e.target.id + '/';
        // setPostUrl(url);
        // getPost(url).then(r => {});
    }

    console.log(dataPairs);


    return (
        <section className="index_exch">
            <div className="i_ex_heading">
                <h1>Обмен криптомонет</h1>
            </div>
            <div className="tmp" id="tmp-exchanger">

                <div className="i_ex_rate">
                    <p>
                        <img src = {fromCurrency ? `images/logo_${fromCurrency}.svg` : ''} alt = {fromCurrency}/> {fromPrice} = {Number(toPrice)} <img src = {toCurrency ? `images/logo_${toCurrency}.svg` : ''} alt = {toCurrency}/>
                    </p>
                    {/*<span className="timer">{rateTime}</span>*/}
                </div>

                <form action="" id="form_ex">
                    <div className="i_ex_fields">
                        <div className="i_ex_f_elems">

                            <Input
                                selectFrom = {fromCurs}
                                selectTo = {toCurs}
                                currencyFrom = {fromCurrency}
                                currencyTo = {toCurrency}
                                titles = {getTitles}
                                factorFrom={2}
                                factorTo={2}
                                chooseFrom = {chooseFromCurrency}
                                chooseTo = {chooseToCurrency}
                                sumFromMin = {minFromSum}
                                sumFromMax = {maxFromSum}
                                sumToMax = {maxToSum}
                                rate = {rateExch}
                                isFiat = {isFiat}
                            />

                        </div>
                    </div>

                    <div className="i_ex_btn">
                        <button className="yellow_btn" type="button" onClick={()=>getBackend()}>Обменять</button>
                    </div>
                </form>

            </div>
        </section>
    );
};

export default MainSectionExch;