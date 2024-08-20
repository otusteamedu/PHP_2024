import Cookie from 'js-cookie';

const getCookie = (cookiename) => {

    if (!cookiename) return Cookie.get();
    else return Cookie.get(cookiename);
};

export default getCookie;