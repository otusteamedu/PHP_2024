import axios from "axios";

export default class PostServices {

    // process.env.REACT_APP_API_URL
    static API_URL = '/libs/react.php';

    static async getPageData(page = '') {

        try {
            const res = await axios({
                url: this.API_URL,
                credentials: true,
                method: 'post',
                httpOnly: true,
                data: {
                    page: page
                },
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
                url: this.API_URL,
                method: 'post',
                httpOnly: true, // Cors error...
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