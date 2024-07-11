import React, {useEffect} from 'react';
import MainSectionExch from './MainSectionExch';


const Main = () => {

    useEffect(() => {
        document.title = 'Купить/продать USDT, BTC, ETH на Coinschest. Автоматический обмен.';
    },[]);

    return (
        <div className="container">
            <MainSectionExch />
        </div>
    );
};

export default Main;