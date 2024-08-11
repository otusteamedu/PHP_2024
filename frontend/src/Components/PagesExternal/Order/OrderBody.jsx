import React from "react";
import {useParams} from "react-router-dom";
import GetServices from "../../Helpers/GetServices";

const OrderBody = ({ data }) => {


    const param = useParams();

    const [status, setStatus] = React.useState("");

    const orderStatusUpdateTime = 20;

    const orderStatus = {
        0: "Отменен",
        1: "В ожидании оплаты",
        2: "Оплачено",
        3: "Выполнен"
    };

    const timer = (time) => {
        return time;
    }


    React.useEffect(() => {
        setStatus(orderStatus[data.status]);
    }, [data.status]);

    const cancelOrder = async () => {
        await GetServices.cancelOrder(param.id)
            .then(res => {
                setStatus(orderStatus[res]);
            })
            .catch(error => console.log(error));
    }

    const updateOrderStatus = async () => {
        await GetServices.getOrderStatus(param.id)
            .then(res => {
                if (res) {
                    setStatus(orderStatus[res]);
                    console.log(res);
                }
            })
    }

    //console.log(data);

    React.useEffect(() => {
        const interval = setInterval(() => {
            updateOrderStatus()
                .then(() => {})
                .catch((err) => console.warn(err))

        }, orderStatusUpdateTime * 1000);
        return () => clearInterval(interval);

    });

    return (

        <div className="ob_div">
            <div className="ob_d_nonce">
                <h3>Для оплаты заказа переведите точную сумму <span>{data.amount_from} {data.cur_from}</span> на данный адрес</h3>
                <h3><span>{data.incoming_asset}</span></h3>
            </div>

            <div className="ob_d_info">

                <div className="ob_d_i">
                    <div className="ob_d_i_left"><p>Отдаете:</p></div>
                    <div className="ob_d_i_right"><p>{data.amount_from} {data.cur_from}</p></div>
                </div>

                <div className="ob_d_i">
                    <div className="ob_d_i_left"><p>Получаете:</p></div>
                    <div className="ob_d_i_right"><p>{data.amount_to} {data.cur_to}</p></div>
                </div>

                <div className="ob_d_i">
                    <div className="ob_d_i_left"><p>Курс обмена:</p></div>
                    <div className="ob_d_i_right"><p>{data.rateFrom} {data.cur_from} = {data.rateTo} {data.cur_to}</p>
                    </div>
                </div>

                <div className="ob_d_i">
                    <div className="ob_d_i_left"><p>Email:</p></div>
                    <div className="ob_d_i_right"><p>{data.email}</p>
                    </div>
                </div>

                <div className="ob_d_i">
                    <div className="ob_d_i_left"><p>Статус заказа:</p></div>
                    <div className="ob_d_i_right"><p>{status}</p>
                    </div>
                </div>

                {
                    status === orderStatus[1] && (
                        <div className="ob_d_i">
                            <div className="ob_d_i_left"><p>Время действия заказа:</p></div>
                            <div className="ob_d_i_right"><p>{timer(30)} мин</p>
                            </div>
                        </div>
                    )
                }


            </div>

            {
                status === orderStatus[1] && (
                    <div className="ob_d_btn">
                        <button className="red_btn" onClick={() => cancelOrder()}><span>Отменить</span></button>
                    </div>
                )
            }


        </div>


    );
};

export default OrderBody;