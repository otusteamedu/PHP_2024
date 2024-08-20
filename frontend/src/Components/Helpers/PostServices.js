import axios from "axios";

export default class PostServices {

    static API_CREATE_ORDER_URL = process.env.REACT_APP_API_URL + 'createOrder';


    static async sendForm(form) {
        try {
            const res = await axios({
                url: this.API_CREATE_ORDER_URL,
                method: 'post',
                httpOnly: true, // Cors error...
                data: form,
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