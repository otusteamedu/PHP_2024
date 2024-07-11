import {useSelector} from "react-redux";

export function authCheck() {
    const {email, id, token} = useSelector(state => state.user);

    return {
        isAuth: !!email,
        email,
        id,
        token
    }
}