import React from 'react';
import Input from "./UIElements/Input";
import PostServices from "../../Helpers/PostServices";


const MainSectionExch = () => {

    // Данные для обмена
    const [data, setData] = React.useState({});

    // URL запроса
    const [postUrl,setPostUrl] = React.useState('');

    // Установка валют
    const [fromCurrency,setFromCurrency] = React.useState('');
    const [toCurrency,setToCurrency] = React.useState('');

    // Установка допустимых валют для обмена
    const [fromCurs,setFromCurs] = React.useState([]);
    const [toCurs,setToCurs] = React.useState([]);

    // Курс обмена
    const [fromPrice,setFromPrice] = React.useState('');
    const [fromPriceCur,setFromPriceCur] = React.useState('');
    const [toPrice,setToPrice] = React.useState('');
    const [toPriceCur,setToPriceCur] = React.useState('');

    // Мин. и макс. сумма
    const [minFromSum,setMinFromSum] = React.useState(null);
    const [maxFromSum,setMaxFromSum] = React.useState(null);
    const [maxToSum,setMaxToSum] = React.useState(null);

    const [getTitles, setGetTitles] = React.useState();

    // Проверка на фиат для округления
    const [isFiat, setIsFiat] = React.useState(false);

    // Курс обмена
    const [rateExch,setRateExch] = React.useState('');
    //const [rateToFrom,setRateToFrom] = React.useState(0);

    // Время обновления данных
    const time = 15;
    // const [rateTime,setRateTime] = React.useState(0);
    //
    // const counter = () => {
    //     setRateTime(time - 1);
    // }

    const getPost = async (postUrl) => {
        //setData({data:{},param:{}});
    }

    const getBackend = async () => {
        await PostServices.getPageData()
            .then(res => setData(res));
            //.then(res => console.log(res));
        console.log(data);
    }

    const currency = data.data;
    const dataParam = data.param;

    let titles = {};
    let curProp = {};
    for (let key1 in data.op) {
        if (data.op.hasOwnProperty(key1)) {
            titles[key1] = data.op[key1].t;
            curProp[key1] = data.op[key1].r;
        }
    }

    // Сортируем доступные валюты
    const currencyAll = () => {
        let curArray = {
            from: {curs: [], defaultCode:''},
            to: {curs: [], defaultCode:''}
        };

        for (let key in currency) {

            if (currency.hasOwnProperty(key)) {

                if (currency[key] instanceof Object) {
                    curArray.from.defaultCode = key;

                    for (let cur in currency[key]) {

                        if (currency[key].hasOwnProperty(cur)) {

                            if (currency[key][cur] === 3) {
                                curArray.to.defaultCode = cur;
                            }
                            else if (currency[key][cur] === 1) {
                                curArray.to.curs.push(cur);
                            }
                            else console.warn('Проблема....')
                        }
                    }
                } else {
                    curArray.from.curs.push(key);
                }
            }
        }
        //console.log(curArray);
        return curArray;
    }

    const rate = () => {
        //console.log(Object.getOwnPropertyNames(data.param));
        let rate = {
            fromValue: '',
            fromCur: '',
            toValue: '',
            toCur: '',
            exch: '',
        }

        for (let prop in dataParam) {
            if (dataParam.hasOwnProperty(prop)) {
                let reverse = false;
                if (prop === 'rt') {
                    //console.log((dataParam[prop].b).toLowerCase());
                    if ((dataParam[prop].b).toLowerCase() === fromCurrency) {
                        rate.fromValue = dataParam[prop].a;
                        rate.fromCur = dataParam[prop].b;
                        rate.toValue = dataParam[prop].c;
                        rate.toCur = dataParam[prop].d;
                    } else {
                        reverse = true;
                        rate.fromValue = dataParam[prop].c;
                        rate.fromCur = dataParam[prop].d;
                        rate.toValue = dataParam[prop].a;
                        rate.toCur = dataParam[prop].b;
                    }
                    //console.log(fromPrice + ' ' + fromPriceCur + ' = ' + toPrice + ' ' + toPriceCur);
                }

                if (prop === 'op') {
                    if (dataParam[prop].hasOwnProperty('isFromCrypto')) {
                        if (!reverse) rate.exch = rate.toValue;
                        else rate.exch = rate.fromValue;
                    }
                    if (dataParam[prop].hasOwnProperty('isFromFiat')) {
                        if (reverse) rate.exch = 1 / rate.toValue;
                        else rate.exch = 1 / rate.fromValue;
                        rate.isFiat = 'fs';
                    }
                    if (dataParam[prop].hasOwnProperty('isToFiat')) rate.isFiat = 'ts';
                }
            }

        }
        return rate;

    }

    const setMinMax = () => {

        let minMax = {
            minFrom: 0,
            maxFrom: 0,
            maxTo: 0,
        }

        for (let prop in dataParam) {
            if (dataParam.hasOwnProperty(prop)) {
                if (prop === 'ri') {
                    minMax.minFrom = dataParam[prop];
                    minMax.minFrom = Number(minMax.minFrom).toFixed(curProp[fromCurrency]);
                }

                if (prop === 'ss') {
                    minMax.maxTo = dataParam[prop];
                    minMax.maxTo = Number(minMax.maxTo).toFixed(curProp[toCurrency]);
                }

                if (prop === 'ra') {
                    minMax.maxFrom = dataParam[prop];
                    minMax.maxFrom = Number(minMax.maxFrom).toFixed(curProp[fromCurrency]);
                }
            }

        }
        return minMax;
    }



    React.useEffect(() => {

        if (!getTitles) setGetTitles(titles);
        // if (getCookie('fc') && getCookie('tc')) {
        //     setPostUrl('/exchanger/' + getCookie('fc') + '-' + getCookie('tc') + '/');
        // }
        if (!postUrl) setPostUrl('index');

        if (!Object.keys(data).length) {

            try {
                getPost(postUrl).then(r => {});
            } catch (e) {
                console.warn(e.message());
            }
        }

        if (!rateExch) setRateExch(rate().exch);
    });

    const chooseFromCurrency = (e) => {
        setFromCurrency(e.target.id);
        //setCookie('fc',e.target.id);
        let url = '/exchanger/' + e.target.id + '-' + toCurrency + '/';
        setPostUrl(url);
        getPost(url).then(r => {});
    }

    const chooseToCurrency = (e) => {
        setToCurrency(e.target.id);
        //setCookie('tc',e.target.id);
        let url = '/exchanger/' + fromCurrency + '-' + e.target.id + '/';
        setPostUrl(url);
        getPost(url).then(r => {});
    }

    React.useEffect(() => {
        if (!fromCurrency && !toCurrency) {
            setFromCurrency(currencyAll().from.defaultCode);
            setToCurrency(currencyAll().to.defaultCode);
            //setCookie('fc',currencyAll().from.defaultCode);
            //setCookie('tc',currencyAll().to.defaultCode);
            //setCookie('titles',JSON.stringify(titles));
        }
        setFromCurs(currencyAll().from.curs);
        setToCurs(currencyAll().to.curs);
        setToCurrency(currencyAll().to.defaultCode);
        setGetTitles(titles);
        //setCookie('tc', currencyAll().to.defaultCode);
        setFromPrice(rate().fromValue);
        setFromPriceCur(rate().fromCur);
        setToPrice(rate().toValue);
        setToPriceCur(rate().toCur);
        setRateExch(rate().exch);
        setMinFromSum(setMinMax().minFrom);
        setMaxFromSum(setMinMax().maxFrom);
        setMaxToSum(setMinMax().maxTo);
        setIsFiat(rate().isFiat);
    },[data]);

    React.useEffect(() => {
        const interval = setInterval(() => {
            getPost(postUrl)
                .then(() => {})
                .catch((err) => console.warn(err))
        }, time * 1000);
        return () => clearInterval(interval);
    });

    return (
        <section className="index_exch">
            <div className="i_ex_heading">
                <h1>Обмен криптомонет</h1>
            </div>
            <div className="tmp" id="tmp-exchanger">

                <div className="i_ex_rate">
                    <p>
                        <img src = {fromPriceCur ? `images/logo_${fromPriceCur}.svg` : ''} alt = {fromPriceCur}/> {Number(fromPrice).toFixed(curProp[fromCurrency])} = {Number(toPrice).toFixed(curProp[toCurrency])} <img src = {toPriceCur ? `images/logo_${toPriceCur}.svg` : ''} alt = {toPriceCur}/>
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
                                factorFrom = {curProp[fromCurrency]}
                                currencyTo = {toCurrency}
                                factorTo = {curProp[toCurrency]}
                                titles = {getTitles}
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