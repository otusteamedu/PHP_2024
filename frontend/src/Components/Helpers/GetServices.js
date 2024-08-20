import axios from "axios";

export default class GetServices {

    static API_RATES_URL = process.env.REACT_APP_API_URL + 'rates';
    static API_GET_ORDER_URL = process.env.REACT_APP_API_URL + 'order/';
    static API_CANCEL_ORDER_URL = process.env.REACT_APP_API_URL + 'cancelOrder/';

    static async getRatesData() {

        try {
            const res = await axios({
                url: this.API_RATES_URL,
                credentials: true,
                method: 'get',
                httpOnly: true,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With' : 'XMLHttpRequest',
                     'xsrfCookieName': 'XSRF-TOKEN',
                    'xsrfHeaderName': 'X-XSRF-TOKEN',
                }
            });
            //console.log(res);
            return res.data;
        } catch (e) {
            console.log('что-то пошло не так ...' + e);
        }

    }

    static async getOrderStatus(id) {

        try {
            const res = await axios({
                url: this.API_GET_ORDER_URL + id + '/status',
                credentials: true,
                method: 'get',
                httpOnly: true,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With' : 'XMLHttpRequest',
                    'xsrfCookieName': 'XSRF-TOKEN',
                    'xsrfHeaderName': 'X-XSRF-TOKEN',
                }
            });
            return res.data;
        } catch (e) {
            console.log('что-то пошло не так ...' + e);
        }
    }


    static async getOrderData(id) {

        try {
            const res = await axios({
                url: this.API_GET_ORDER_URL + id,
                credentials: true,
                method: 'get',
                httpOnly: true,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With' : 'XMLHttpRequest',
                     'xsrfCookieName': 'XSRF-TOKEN',
                    'xsrfHeaderName': 'X-XSRF-TOKEN',
                }
            });
            return res.data;
        } catch (e) {
            console.log('что-то пошло не так ...' + e);
        }
    }

    static async cancelOrder(id) {

        try {
            const res = await axios({
                url: this.API_CANCEL_ORDER_URL + id,
                credentials: true,
                method: 'get',
                httpOnly: true,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With' : 'XMLHttpRequest',
                    'xsrfCookieName': 'XSRF-TOKEN',
                    'xsrfHeaderName': 'X-XSRF-TOKEN',
                }
            });
            return res.data;
        } catch (e) {
            console.log('что-то пошло не так ...' + e);
        }
    }
}