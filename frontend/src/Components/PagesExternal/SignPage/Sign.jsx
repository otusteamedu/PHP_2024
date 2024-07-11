import React from 'react';
import {Login} from "./login";
import {Registration} from "./registration";
import {Confirm} from "./confirm";
import {useSelector} from "react-redux";
import getCookie from "../../customHooks/getCookie";
import {ACCESS_TOKEN} from "../../User/const";
import {useNavigate} from "react-router-dom";


export const Sign = () => {

    const action = useSelector(state => state.sign.page)
    const email = useSelector(state => state.sign.email.payload)

    function renderSwitch(action) {
        switch (action) {
            case 'login': return <Login/>
            case 'register': return <Registration/>
            case 'confirm': return <Confirm email={email}/>
            default: return <Login/>
        }
    }

    return (
        <div className="container">
            {renderSwitch(action)}
        </div>
    );
};