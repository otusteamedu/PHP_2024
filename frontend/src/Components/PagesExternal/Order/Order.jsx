import React, {useEffect} from 'react';
import OrderBody from "./OrderBody";
import {useParams} from "react-router-dom";


const Order = ({ props }) => {

    const dataParam = useParams();

    console.log(props);
    console.log(dataParam);
    useEffect(() => {
        document.title = 'Заказ на обмен №' + dataParam.id;
    },[]);

    return (
        <div className="container">
            <OrderBody />
        </div>
    );
};

export default Order;