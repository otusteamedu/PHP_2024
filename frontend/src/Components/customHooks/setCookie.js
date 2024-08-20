import Cookie from 'js-cookie';

const setCookie = (name,value) => {
    Cookie.set(name,value,{
        expires: 1,
        secure: true,    //true на паблике
        sameSite: 'strict',
        path: '/'
    });
};

export default setCookie;