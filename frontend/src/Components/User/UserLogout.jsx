import React from "react";
import {Sign} from "../PagesExternal/SignPage/Sign";
import PostServices from "../Helpers/PostServices";
import {LOGOUT_PAGE} from "../PagesExternal/SignPage/Constants";
import {useDispatch} from "react-redux";
import {logOut} from "../../redux/slices/userSlice";


const UserLogout = () => {

    const dispatch = useDispatch();
    const loqout = async () => {
        await PostServices.getPageData(LOGOUT_PAGE)
            .then(() => {
                dispatch(logOut())
            });
    }

    return (
        <>
            <div className="container">

                <Sign />

            </div>
        </>
    )

};

export default UserLogout;