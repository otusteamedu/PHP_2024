import axios from "axios";

export default class PostServices {

    static API_RATES_URL = process.env.REACT_APP_API_URL + 'rates';
    static API_CREATE_ORDER_URL = process.env.REACT_APP_API_URL + 'createOrder';

    static async getPageData() {

        try {
            const res = await axios({
                url: this.API_RATES_URL,
                credentials: true,
                method: 'get',
                httpOnly: true,
                // data: {
                //     page: page
                // },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With' : 'XMLHttpRequest',
                    //  'xsrfCookieName': 'XSRF-TOKEN',
                    // 'xsrfHeaderName': 'X-XSRF-TOKEN',
                }
            });
            //console.log(res);
            return res.data;
        } catch (e) {
            console.log('что-то пошло не так ...' + e);
        }

    }

    static async sendForm(form) {
        try {
            const res = await axios({
                url: this.API_CREATE_ORDER_URL,
                method: 'post',
                //httpOnly: true, // Cors error...
                data: form,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With' : 'XMLHttpRequest',
                    // 'xsrfCookieName': 'XSRF-TOKEN',
                    // 'xsrfHeaderName': 'X-XSRF-TOKEN',
                }
            });
            return res.data;
        } catch (e) {
            console.log('что-то пошло не так ...' + e);
        }
    }

}