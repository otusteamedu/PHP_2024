import Cookie from 'js-cookie';

const removeCookie = (cookiename) => {

    return Cookie.remove(cookiename);

}

export default removeCookie;