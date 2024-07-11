import {createSlice} from "@reduxjs/toolkit";
import {CONFIRM, LOGIN, REGISTER} from "../types";

const signSlice = createSlice({
    name: 'signSlice',
    initialState: { page: LOGIN, email: '',password: '' },
    reducers: {
        pageLogin(state) {
            state.page = LOGIN
        },
        pageRegister(state) {
            state.page = REGISTER
        },
        pageConfirm(state,email,password) {
            state.page = CONFIRM;
            state.email = email
            state.password = password
        }
    }
});

export const { pageLogin, pageRegister, pageConfirm } = signSlice.actions;
export default signSlice.reducer;


// const initialState = {
//     page: LOGIN,
//     email: ''
// }
//
// export const pageLogin = createAction(LOGIN)
// export const pageRegister = createAction(REGISTER)
// export const pageConfirm = createAction(CONFIRM)
//
// export default createReducer(initialState,{
//     [pageLogin] : function (state) {
//       state.page = LOGIN
//     },
//     [pageRegister] : function (state) {
//         state.page = REGISTER
//     },
//     [pageConfirm] : function (state, email) {
//         state.page = CONFIRM
//         state.email = email
//     },
// })