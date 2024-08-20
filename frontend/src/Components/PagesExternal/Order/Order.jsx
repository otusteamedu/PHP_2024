import React, {useEffect} from 'react';
import OrderBody from "./OrderBody";
import {useParams} from "react-router-dom";
import GetServices from "../../Helpers/GetServices";


const Order = () => {

    const dataParam = useParams();
    const [orderData, setOrderData] = React.useState({});

    const getOrderData = async (id) => {
        await GetServices.getOrderData(id)
            .then(res => {
                setOrderData(res);
            })
            .catch(error => console.log(error));
    }

    // Загрузка компонента при первом рендере компонента
    useEffect(() => {
        // Загрузка данных заказа
        if (Object.keys(orderData).length === 0) {
            getOrderData(dataParam.id);
        }
        document.title = 'Заказ на обмен №' + dataParam.id;
    },[]);

    return (
        <div className="container">

            <div className="page_head">
                <div className="log_head_title">
                    <h2>Оплата заказа № {dataParam.id}</h2>
                </div>
            </div>
            <OrderBody data={orderData}/>
        </div>
    );
};

export default Order;